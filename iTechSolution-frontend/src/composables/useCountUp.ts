import { ref, onMounted, onUnmounted, type Ref } from 'vue'

export function useCountUp(target: number, duration = 1800): { value: Ref<number>; el: Ref<HTMLElement | null> } {
  const value = ref(0)
  const el = ref<HTMLElement | null>(null)
  let observer: IntersectionObserver | null = null

  function animate() {
    const start = performance.now()
    function step(now: number) {
      const progress = Math.min((now - start) / duration, 1)
      const ease = 1 - Math.pow(1 - progress, 3)
      value.value = Math.round(ease * target)
      if (progress < 1) requestAnimationFrame(step)
    }
    requestAnimationFrame(step)
  }

  onMounted(() => {
    if (!el.value) return
    if (typeof IntersectionObserver === 'undefined' || window.matchMedia?.('(prefers-reduced-motion: reduce)').matches) {
      value.value = target
      return
    }
    observer = new IntersectionObserver(
      (entries) => {
        if (entries[0]?.isIntersecting) {
          animate()
          observer?.disconnect()
        }
      },
      { threshold: 0.3 },
    )
    observer.observe(el.value)
  })

  onUnmounted(() => observer?.disconnect())

  return { value, el }
}
