<template>
  <main class="about">
    <div class="header">
      <h1>Product List</h1>
      <div class="settings-container">
        <button @click="saveBtn">Save</button>
        <button @click="$router.push('/')">Cancel</button>
      </div>
    </div>
    <form id="product_form" class="form">
      <BaseInput
        :validate="validate"
        :error="errors.sku"
        title="SKU"
        id="sku"
        v-model.trim="form.sku"
      />
      <BaseInput
        :validate="validate"
        title="Name"
        id="name"
        v-model.trim="form.name"
      />
      <BaseInput
        :validate="validate"
        title="Price"
        id="price"
        v-model.trim="form.price"
      />
      <div class="field">
        <h3>Type Switcher</h3>
        <select id="productType" v-model="type">
          <option disabled value="0">Select a type</option>
          <option value="DVD">DVD</option>
          <option value="Furniture">Furniture</option>
          <option value="Book">Book</option>
        </select>
      </div>
      <div v-if="type == 'DVD'">
        <BaseInput
          :validate="validate"
          title="Size"
          id="size"
          v-model.trim="form.size"
        />
        <p>Please provide dimensions in MB format.</p>
      </div>
      <div v-if="type == 'Furniture'">
        <BaseInput
          :validate="validate"
          title="Length"
          id="length"
          v-model.trim="form.length"
        />
        <BaseInput
          :validate="validate"
          title="Width"
          id="width"
          v-model.trim="form.width"
        />
        <BaseInput
          :validate="validate"
          title="Height"
          id="height"
          v-model.trim="form.height"
        />
        <p>Please provide dimensions in HxLxW format.</p>
      </div>
      <div v-if="type == 'Book'">
        <BaseInput
          :validate="validate"
          title="Weight"
          id="weight"
          v-model.trim="form.weight"
        />
        <p>Please provide dimensions in weight format.</p>
      </div>
    </form>
  </main>
</template>
<script>
import BaseInput from "@/components/Base/BaseInput.vue";
import { mapActions, mapState } from "vuex";
export default {
  components: {
    BaseInput,
  },
  data() {
    return {
      test: "",
      type: "0",
      form: {
        sku: "",
        name: "",
        price: "",
        length: null,
        width: null,
        height: null,
        size: null,
        weight: null,
      },
      validate: false,
    };
  },
  computed: {
    ...mapState({ errors: "errors" }),
  },
  methods: {
    ...mapActions(["addProduct"]),
    saveBtn() {
      this.validate = true;
      if (!this.form.sku) {
        return;
      }
      if (!this.form.name) {
        return;
      }
      if (!this.form.price) {
        return;
      }
      if (this.type == "DVD" && !this.form.size) {
        return;
      }
      if (!this.type == "Book" && !this.form.weight) {
        return;
      }
      if (
        !this.type == "Furniture" &&
        !this.form.length &&
        !this.form.width &&
        !this.form.height
      ) {
        return;
      }
      this.addProduct({ ...this.form, type: this.type }).then(() => {
        (this.form.sku = ""),
          (this.form.name = ""),
          (this.form.price = ""),
          (this.form.length = null),
          (this.form.width = null),
          (this.form.height = null),
          (this.form.size = null),
          (this.form.weight = null),
          (this.validate = false);
      });
      console.log(this.errors.sku);
    },
  },
};
</script>
<style scoped>
.form {
  display: flex;
  flex-direction: column;
  gap: 30px;
  width: fit-content;
}
</style>
