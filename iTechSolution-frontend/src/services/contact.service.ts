import { post } from './http'

export interface ContactPayload {
  name: string
  email: string
  message: string
}

export async function submitContact(payload: ContactPayload): Promise<void> {
  await post('/contact', payload)
}
