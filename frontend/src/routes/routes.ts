import MoviePage from '../pages/MoviePage.vue';
import HomePage from '../pages/HomePage.vue';
import NotFound from '../pages/404.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: HomePage
    },
    {
        name: 'movies',
        path: '/movies',
        component: MoviePage
    },
    {
        name: 'not-found',
        path: '/:pathMatch(.*)*',
        component: NotFound
    }
];