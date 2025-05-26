  import { defineStore } from 'pinia';
  import axios from 'axios';
  import type { PostIt } from '../types';

  export const usePostItStore = defineStore('postIts', {
    state: () => ({
      postIts: [] as PostIt[],
      loading: false,
      error: null as string | null,
    }),

    actions: {
      async fetch() {
        this.loading = true;
        this.error = null;

        try {
          const response = await axios.get('/api/post-its', {
            withCredentials: true
          });
          this.postIts = response.data.data;
        } catch (e: any) {
          this.error = e.response?.data?.message || 'Failed to fetch post-its';
          console.error('Error fetching post-its:', e);
        } finally {
          this.loading = false;
        }
      },

      async create(postIt: Omit<PostIt, 'id' | 'created_at' | 'user'>) {
        this.loading = true;
        this.error = null;

          try {
              await axios.get('/sanctum/csrf-cookie', { withCredentials: true });

              const response = await axios.post('/api/post-its', postIt, {
                  withCredentials: true,
                  headers: {
                      'Content-Type': 'application/json',
                      'Accept': 'application/json',
                      'X-XSRF-TOKEN': decodeURIComponent(
                          document.cookie
                              .split('; ')
                              .find(row => row.startsWith('XSRF-TOKEN='))
                              ?.split('=')[1] || ''
                      )
                  }
              });

              if (!this.postIts) {
                  this.postIts = [];
              }

              const newPostIt = response.data.data;
              this.postIts = [newPostIt, ...this.postIts];
              return newPostIt;
          } catch (e: any) {
              this.error = e.response?.data?.message || 'Failed to create post-it';
              console.error('Error creating post-it:', e);
              throw e;
          } finally {
              this.loading = false;
          }
      },

        async update(id: number, data: Partial<PostIt>) {
            this.loading = true;
            this.error = null;

            try {
                await axios.get('/sanctum/csrf-cookie', { withCredentials: true });

                const response = await axios.put(`/api/post-its/${id}`, data, {
                    withCredentials: true,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': decodeURIComponent(
                            document.cookie
                                .split('; ')
                                .find(row => row.startsWith('XSRF-TOKEN='))
                                ?.split('=')[1] || ''
                        )
                    }
                });

                const updatedPostIt = response.data.data;
                this.postIts = this.postIts.map(p =>
                    p.id === id ? updatedPostIt : p
                );
                return updatedPostIt;
            } catch (e: any) {
                this.error = e.response?.data?.message || 'Failed to update post-it';
                console.error('Error updating post-it:', e);
                throw e;
            } finally {
                this.loading = false;
            }
        },

      async delete(id: number) {
        this.loading = true;
        this.error = null;

        try {
          await axios.get('/sanctum/csrf-cookie', { withCredentials: true });

          await axios.delete(`/api/post-its/${id}`, {
            withCredentials: true,
            headers: {
              'Accept': 'application/json',
              'X-XSRF-TOKEN': decodeURIComponent(
                document.cookie
                  .split('; ')
                  .find(row => row.startsWith('XSRF-TOKEN='))
                  ?.split('=')[1] || ''
              )
            }
          });

          this.postIts = this.postIts.filter(p => p.id !== id);
        } catch (e: any) {
          this.error = e.response?.data?.message || 'Failed to delete post-it';
          console.error('Error deleting post-it:', e);
          throw e;
        } finally {
          this.loading = false;
        }
      }
    }
  });
