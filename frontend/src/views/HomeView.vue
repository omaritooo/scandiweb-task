<template>
  <main>
    <div class="header">
      <h1>Product List</h1>
      <div class="settings-container">
        <button @click="action(0)">MASS DELETE</button>
        <button @click="action(1)">ADD</button>
      </div>
    </div>
    <div class="card-container">
      <BaseCard
        v-for="(product, index) in getProducts"
        :key="index"
        :product="product"
      />
    </div>
  </main>
</template>
<script>
import BaseCard from "@/components/Base/BaseCard.vue";
import { mapActions, mapGetters, mapState } from "vuex";
export default {
  mounted() {
    this.fetchProducts();
  },
  components: {
    BaseCard,
  },
  data() {
    return {};
  },
  computed: {
    ...mapState(["products", "checkedArray"]),
    ...mapGetters(["getProducts", "getCheckedArray"]),
  },
  methods: {
    ...mapActions({ fetchProducts: "fetchProducts", massDelete: "massDelete" }),

    action(option) {
      if (option == 0) {
        let checkedStr = "";
        this.checkedArray.forEach((el, idx) => {
          if (idx == 0) {
            checkedStr += `${el}`;
          } else {
            checkedStr += `,${el}`;
          }
        });

        this.massDelete(checkedStr);
        checkedStr = "";
      } else {
        this.$router.push("/product");
      }
    },
  },
};
</script>
<style scoped>
.card-container {
  display: flex;
  justify-content: space-between;
  width: 100%;
  gap: 30px 0;
  margin-top: 40px;
  flex-wrap: wrap;
}
</style>
