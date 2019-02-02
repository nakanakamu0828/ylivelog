export default {
  user: ({ user }) => user,
  isLoggined: (state) => !!state.user,
}
