import type { Directive } from 'vue'

interface RevealOptions {
  delay?: number
  threshold?: number
}

type RevealValue = RevealOptions | number | undefined

const observers = new WeakMap<Element, IntersectionObserver>()

function resolveOptions(value: RevealValue): RevealOptions {
  if (typeof value === 'number') return { delay: value }
  if (value && typeof value === 'object') return value
  return {}
}

function prefersReducedMotion(): boolean {
  return typeof window !== 'undefined' && window.matchMedia?.('(prefers-reduced-motion: reduce)').matches
}

export const vReveal: Directive<HTMLElement, RevealValue> = {
  mounted(el, binding) {
    const { delay = 0, threshold = 0.15 } = resolveOptions(binding.value)

    el.classList.add('reveal')
    if (delay) el.style.setProperty('--reveal-delay', `${delay}ms`)

    if (prefersReducedMotion() || typeof IntersectionObserver === 'undefined') {
      el.classList.add('reveal--visible')
      return
    }

    const io = new IntersectionObserver(
      (entries) => {
        for (const entry of entries) {
          if (entry.isIntersecting) {
            el.classList.add('reveal--visible')
            io.unobserve(el)
          }
        }
      },
      { threshold, rootMargin: '0px 0px -10% 0px' },
    )

    io.observe(el)
    observers.set(el, io)
  },
  unmounted(el) {
    observers.get(el)?.disconnect()
    observers.delete(el)
  },
}
