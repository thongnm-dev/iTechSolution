import { get } from './http'
import type { AboutContent, Project, Service } from '@/types/content'

export function getServices(): Promise<Service[]> {
  return get<Service[]>('/services')
}

export function getProjects(): Promise<Project[]> {
  return get<Project[]>('/projects')
}

export function getAboutContent(): Promise<AboutContent> {
  return get<AboutContent>('/about')
}
