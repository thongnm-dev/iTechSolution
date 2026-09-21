export interface Service {
  icon: string
  title: string
  description: string
}

export interface Project {
  title: string
  category: string
  description: string
  image: string | null
}

export interface AboutValue {
  icon: string
  title: string
  description: string
}

export interface AboutStat {
  value: string
  label: string
}

export interface AboutContent {
  heroTitle: string
  heroSubtitle: string | null
  storyParagraphs: string[]
  storyImage: string | null
  vision: string | null
  mission: string | null
  values: AboutValue[]
  stats: AboutStat[]
}
