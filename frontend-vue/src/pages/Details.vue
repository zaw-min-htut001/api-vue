<template>
  <header>
    <nav
      class="flex justify-between items-center h-[80px] border-b xl:px-[80px] md:px-[50px] px-[20px]"
    >
      <div>
        <router-link
          :to="{ name: 'home' }"
          class="text-3xl text-green-400 font-semibold"
          >My Recipe</router-link
        >
      </div>
      <div>
        <router-link
          :to="{ name: 'recipeForm' }"
          class="px-3 py-3 rounded-lg bg-red-400 hover:opacity-[0.85] transition-all duration-500 text-white flex items-center gap-2"
        >
          <i class="fa-solid fa-plus"></i>
          <div>Add Recipe</div>
        </router-link>
      </div>
    </nav>
  </header>

  <main
    class="flex gap-5 items-center md:flex-row flex-col xl:px-[80px] md:px-[50px] px-[20px] my-11"
  >
    <img class="max-h-[400px]" :src="recipe.photo" alt="product image" />
    <div class="space-y-5">
      <h5
        class="text-4xl font-semibold tracking-tight text-gray-900 dark:text-dark"
      >
        {{ recipe.name }}
      </h5>
      <p class="text-gray-500">
        {{ recipe.description }}
      </p>
      <div class="flex gap-4 border-t py-5 justify-end">
        <router-link
          :to="{ name: 'recipeEdit', params: recipe.id }"
          class="bg-blue-400 text-white px-4 py-2 rounded-lg"
          >Edit</router-link
        >
        <button
          @click.prevent="deleteRecipe(recipe.id)"
          class="bg-red-500 text-white px-3 py-2 rounded-lg"
        >
          Delete
        </button>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      recipe: [],
    };
  },
  methods: {
    async getSingleRecipe() {
      try {
        const id = this.$route.params.id;
        let res = await this.$axios.get("/recipes/" + id);
        this.recipe = res.data;
      } catch (e) {
        console.log(e.message);
      }
    },
    async deleteRecipe(id) {
      await this.$axios.delete("/recipes/" + id);
      this.$router.push({ name: "home" });
    },
  },
  mounted() {
    this.getSingleRecipe();
  },
};
</script>

<style></style>
