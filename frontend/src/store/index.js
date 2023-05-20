import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    products: [],
    checkedArray: [],
    errors: {}
  },
  getters: {
    getProducts(state) {
      return state.products;
    },
    getCheckedArray(state) {
      return state.checkedArray;
    },
    getFormData(state) {
      let form = new FormData();
      state.checkedArray.forEach((el, idx) => {

        form.append(`productsSku[${idx}]`, el)
      }
      );
      return form;
    }
  },
  mutations: {
    SET_PRODUCTS(state, payload) {
      state.products = payload
    },
    SET_CHECKED_ELEMENT(state, payload) {
      state.checkedArray.push(payload)
    },
    REMOVE_CHECKED_ELEMENT(state, payload) {
      state.checkedArray.splice(state.checkedArray.indexOf(payload), 1);
    },
    SET_ERRORS(state, payload) {
      state.errors = Object.assign({}, state.errors, { ...payload })

    },
  },
  actions: {
    fetchProducts(context) {
      axios
        .get("https://scandiwebtestmidsernior.000webhostapp.com/product/get", {
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((res) => {
          context.commit('SET_PRODUCTS', res.data.data)
        })
        .catch((err) => console.log(err));
    },
    addProduct(context, payload) {

      axios
        .get(
          "https://scandiwebtestmidsernior.000webhostapp.com/product/saveApi",
          { params: payload },

        )
        .then((res) => {
          context.commit('SET_ERRORS', res.data.errors)
          console.log(res.data.errors)
        })
        .catch((err) => console.log(err));

    },
    massDelete(context, payload) {
      axios
        .get(
          `https://scandiwebtestmidsernior.000webhostapp.com/product/delete?productsSku=${payload}`
        )
        .then((res) => {
          if (res.data.success) {
            context.dispatch('fetchProducts')
          }
        });


    },

  }
})
