export interface Category {
  id: number
  name: string
  slug: string
}

export interface Tag {
  id: number
  name: string
  slug: string
}

export interface Author {
  id: number
  name: string
  bio: string
}

export interface Post {
  id: number
  slug: string
  title: string
  excerpt: string
  content: string
  coverImage: string | null
  category: Category
  tags: Tag[]
  author: Author
  publishedAt: string
  minutesToRead: number
}
