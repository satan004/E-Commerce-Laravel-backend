import { createRouter, createWebHistory } from 'vue-router'
import { routes } from '@routes/routes.ts'

const router = createRouter({
	history: createWebHistory(import.meta.url),
	routes,
})

export default router 