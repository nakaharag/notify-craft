import { defineStore } from 'pinia';
import axios from "axios";

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null as null | { id: number; name: string; email: string },
  }),
  actions: {
    setUser(user: { id: number; name: string; email: string }) {
      this.user = user;
    },
      async loginAnonymous() {
          const { data } = await axios.post('/login/anonymous');
          this.setUser(data.data ?? data);
      },
  },
});
