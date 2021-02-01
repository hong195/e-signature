export default {
  state: {
    users: [],
  },
  getters: {
    users: state => state.users,
  },
  mutations: {
    setUsers (state, payload) {
      state.users = payload
    },
  },
}
