import { createWebHistory, createRouter } from "vue-router";

import Home from "@/pages/Home.vue";
import Details from "@/pages/Details.vue";
import RecipeForm from "@/pages/RecipeForm.vue";

const routes = [
  { path: '/', component: Home, name: 'home' },
  { path: '/recipes/:id/details', component: Details, name: 'recipeDetails' },
  { path: '/recipes/form', component: RecipeForm, name: 'recipeForm' },
  { path: '/recipes/:id/edit', component: RecipeForm, name: 'recipeEdit' },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;