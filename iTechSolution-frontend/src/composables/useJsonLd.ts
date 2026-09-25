import { useHead } from '@unhead/vue'
import type { MaybeRef } from 'vue'
import { computed, unref } from 'vue'

export function useJsonLd(data: MaybeRef<Record<string, unknown>>) {
  useHead({
    script: [
      {
        type: 'application/ld+json',
        innerHTML: computed(() => JSON.stringify(unref(data))),
      },
    ],
  })
}
