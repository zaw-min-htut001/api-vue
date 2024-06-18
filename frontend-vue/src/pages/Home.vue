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

  <main class="xl:px-[80px] md:px-[50px] px-[20px]">
    <h1
      class="text-center mt-11 text-5xl font-bold text-gray-800 leading-tight"
    >
      All your favorite <span class="font-bold text-red-400">recipes,</span
      ><br />
      <span class="font-bold text-red-400">in one place</span>
    </h1>

    <div class="justify-center md:flex hidden">
      <nav class="bg-red-400 text-white grid grid-flow-col text-center mt-14">
        <div
          @click="filterRecipe('')"
          class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3 active"
        >
          All recipes
        </div>
        <template v-for="category in categories" :key="category.id">
          <div
            @click="filterRecipe(category.name)"
            class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3"
          >
            {{ category.name }}
          </div>
        </template>
      </nav>
    </div>

    <div class="justify-center mt-11 block md:hidden">
      <select
        class="appearance-none bg-red-400 text-white outline-none border-none p-3 w-[300px] text-center"
        name=""
        id=""
      >
        <option value="">All Recipes</option>
        <div v-for="category in categories" :key="category.id">
          <option value="{{category.id}}">
            {{ category.name }}
          </option>
        </div>
      </select>
    </div>

    <!-- recipe -->
    <div
      v-if="!sleep"
      class="my-20 grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-12"
    >
      <div v-for="recipe in recipes" :key="recipe.id">
        <router-link :to="{ name: 'recipeDetails', params: { id: recipe.id } }">
          <div
            class="max-h-full w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-lg active:shadow-none transition-all duration-500"
          >
            <img
              class="h-[300px] mb-4 rounded-t-lg w-full object-fill"
              :src="recipe.photo"
              alt="product image"
            />
            <div class="px-5 pb-5">
              <h5
                class="line-clamp-1 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white"
              >
                {{ recipe.name }}
              </h5>
              <p class="line-clamp-2 mt-2 text-gray-500">
                {{ recipe.description }}
              </p>
            </div>
          </div>
        </router-link>
      </div>
    </div>
    <div
      v-else
      class="my-20 grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-12"
    >
      <div class="animate-pulse" v-for="(_, inx) in new Array(6)" :key="inx">
        <div class="bg-white border-2 rounded-lg">
          <div
            class="h-[200px] mb-4 rounded-t-lg w-full object-fill bg-slate-400 rounded"
          />
          <div class="px-5 pb-5">
            <h5
              class="line-clamp-1 h-3 text-2xl bg-slate-300 rounded font-semibold tracking-tight text-gray-900 dark:text-white"
            ></h5>
            <p
              class="line-clamp-2 h-4 bg-slate-300 rounded mt-2 text-gray-500"
            ></p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-center items-center gap-4">
      <div
        v-for="item in getPagniationData"
        :key="item.id"
        class="flex items-center gap-2"
      >
        <button
          @click="paginate(item.label)"
          :class="item.label === current_page ? 'bg-slate-900 text-white' : ''"
          class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          type="button"
        >
          <span
            v-html="item.label"
            class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
          >
          </span>
        </button>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      categories: null,
      recipes: [],
      sleep: true,
      getPagniationData: [],
      current_page: 1,
    };
  },
  methods: {
    async filterRecipe(name) {
      try {
        let res = await this.$axios.get("/recipes?category=" + name);
        this.recipes = res.data.data;
      } catch (e) {
        console.log(e.message);
      }
    },
    async getRecipeCategory() {
      try {
        let res = await this.$axios.get("/categories");
        if (res) {
          this.categories = res.data;
        }
      } catch (e) {
        console.log(e.message);
      }
    },

    async getAllRecipe() {
      try {
        let res = await this.$axios.get("/recipes");
        if (res) {
          this.recipes = res.data.data;
          setTimeout(() => {
            this.sleep = false;
          }, 3000);
          this.getPagniationData = res.data.links;
          this.current_page = 1;
          console.log(this.getPagniationData);
        }
      } catch (e) {
        console.log(e.message);
      }
    },
    async paginate(url) {
      try {
        let res = await this.$axios.get("/recipes?page=" + url);
        if (res) {
          this.recipes = res.data.data;
          this.current_page = url;
        }
      } catch (e) {
        console.log(e);
      }
    },
  },
  mounted() {
    this.getRecipeCategory();
    this.getAllRecipe();
  },
};
</script>

<style></style>
