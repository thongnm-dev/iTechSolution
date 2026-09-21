import { get, HttpError } from './http'
import type { Category, Post } from '@/types/blog'

interface PaginatedPosts {
  data: Post[]
  total: number
  page: number
  pageSize: number
}

export async function getPosts(params: { page?: number; pageSize?: number; category?: string; search?: string } = {}) {
  const { page = 1, pageSize = 6, category, search } = params
  const query = new URLSearchParams({ page: String(page), pageSize: String(pageSize) })
  if (category) query.set('category', category)
  if (search) query.set('search', search)

  return get<PaginatedPosts>(`/posts?${query.toString()}`)
}

export async function getPostBySlug(slug: string): Promise<Post | undefined> {
  try {
    return await get<Post>(`/posts/${slug}`)
  } catch (error) {
    if (error instanceof HttpError && error.status === 404) return undefined
    throw error
  }
}

export async function getCategories(): Promise<Category[]> {
  return get<Category[]>('/categories')
}

export async function getRelatedPosts(slug: string): Promise<Post[]> {
  return get<Post[]>(`/posts/${slug}/related`)
}
