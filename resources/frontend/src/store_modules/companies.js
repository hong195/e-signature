export default {
  state: {
    companies: [],
  },
  getters: {
    companies: state => state.companies,
  },
  mutations: {
    setCompanies (state, payload) {
      state.companies = payload
    },
  },
}
