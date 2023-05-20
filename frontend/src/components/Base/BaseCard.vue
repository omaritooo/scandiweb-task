<template>
  <div class="card">
    <input
      v-model="check"
      @change="handleCheck"
      class="delete-checkbox"
      type="checkbox"
    />

    <span> {{ product?.sku }} </span>
    <span> {{ product?.name }} </span>
    <span> {{ product?.price.toFixed(2) }} $ </span>
    <span v-if="product.weight"> Weight: {{ product?.weight }} KG </span>
    <span v-if="product.size"> Size: {{ product?.size }} MB </span>
    <span v-if="product.length">
      {{ product?.length }} x {{ product?.width }} x
      {{ product?.height }}
    </span>
  </div>
</template>

<script>
import { mapMutations } from "vuex";

export default {
  props: {
    product: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      check: false,
      value: false,
    };
  },
  computed: {
    model: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit("onCheck", value);
      },
    },
  },
  methods: {
    ...mapMutations({
      setChecked: "SET_CHECKED_ELEMENT",
      removeChecked: "REMOVE_CHECKED_ELEMENT",
    }),
    handleCheck() {
      if (this.check) {
        this.setChecked(this.product.sku);
      } else {
        this.removeChecked(this.product.sku);
      }
    },
  },
};
</script>

<style scoped>
.card {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
  justify-items: center;
  width: 20vw;

  align-content: center;
  background: white;
  gap: 15px;
  height: 25vh;
  color: black;
  border: 3px black solid;
}
.card span {
  margin: 0 auto;
  height: fit-content;
}
@media screen and (max-width: 768px) {
  .card {
    width: 30vw;
  }
}
@media screen and (max-width: 425px) {
  .card {
    width: 50vw;
    justify-content: center;
    margin: auto;
  }
}
.delete-checkbox {
  position: absolute;
  top: 7%;
  left: 7%;
}
</style>
