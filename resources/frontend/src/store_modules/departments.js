export default {
  state: {
    departments: [],
  },
  getters: {
    departments: state => state.departments,
  },
  mutations: {
    setDepartments (state, payload) {
      state.departments = payload
    },
  },
}
