<template>
  <div class="field-container">
    <div class="field">
      <h2>
        {{ title }}
      </h2>
      <div>
        <input
          :id="id"
          :value="value"
          @change="$emit('change')"
          @input="updateValue($event.target.value)"
          @keyup.enter.prevent="$emit('enter')"
        />
      </div>
    </div>
    <div v-if="validate">
      <span v-if="!value">Please, provide {{ title }} </span>
    </div>
    <span v-if="error">{{ error }}</span>
  </div>
</template>

<script>
export default {
  name: "BaseInput",
  props: {
    value: {
      type: String,
      default: "",
    },

    title: {
      type: String,
      default: "",
    },

    error: {
      type: [String, Boolean],
      default: "",
    },
    validate: {
      type: Boolean,
    },
  },
  computed: {
    id() {
      return `input_${new Date().getTime()}${Math.floor(Math.random() * 1000)}`;
    },
  },
  methods: {
    updateValue(value) {
      let v = value.replace(/  +/g, " ");
      if (this.maxValueLength && value.length > this.maxValueLength) {
        v = value.substr(0, this.maxValueLength);
        this.$refs[this.id].value = v;
      }
      this.$emit("input", v);
    },
  },
};
</script>

<style scoped>
.field-container {
  width: fit-content;
}
</style>
