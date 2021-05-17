
import config from './components/admin/Config'

export const routes = [
	{ path: '/config-abc', name: 'Config', component: config },
	{ path: '/categories/create', name: 'Create', component: CategoryCreateView }
];