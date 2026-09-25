import { useHead } from '@unhead/vue'
import type { MaybeRef } from 'vue'

interface SeoOptions {
  title: MaybeRef<string>
  description?: MaybeRef<string>
}

export function useSeo({ title, description }: SeoOptions) {
  useHead({
    title,
    titleTemplate: '%s | iTechSolution',
    meta: [
      { name: 'description', content: description ?? '' },
      { property: 'og:title', content: title },
      { property: 'og:description', content: description ?? '' },
    ],
  })
}
