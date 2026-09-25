import { useHead } from '@unhead/vue'
import { useRoute } from 'vue-router'
import type { MaybeRef } from 'vue'

const SITE_NAME = 'iTechSolution'
const SITE_URL = 'https://itechsolution.vn'
const DEFAULT_IMAGE = `${SITE_URL}/og-image.png`

interface SeoOptions {
  title: MaybeRef<string>
  description?: MaybeRef<string>
  image?: MaybeRef<string>
  type?: 'website' | 'article'
}

export function useSeo({ title, description, image, type = 'website' }: SeoOptions) {
  const route = useRoute()
  const canonicalUrl = `${SITE_URL}${route.path}`
  const ogImage = image ?? DEFAULT_IMAGE

  useHead({
    title,
    titleTemplate: `%s | ${SITE_NAME}`,
    link: [
      { rel: 'canonical', href: canonicalUrl },
    ],
    meta: [
      { name: 'description', content: description ?? '' },
      { property: 'og:title', content: title },
      { property: 'og:description', content: description ?? '' },
      { property: 'og:image', content: ogImage },
      { property: 'og:url', content: canonicalUrl },
      { property: 'og:type', content: type },
      { property: 'og:site_name', content: SITE_NAME },
      { property: 'og:locale', content: 'vi_VN' },
      { name: 'twitter:card', content: 'summary_large_image' },
      { name: 'twitter:title', content: title },
      { name: 'twitter:description', content: description ?? '' },
      { name: 'twitter:image', content: ogImage },
    ],
  })
}
