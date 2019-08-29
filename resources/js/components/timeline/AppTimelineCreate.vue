<template>
  <form action="#" @submit.prevent="submit">
    <div class="form-group">
      <label for="body" class="sr-only">Share Something</label>
      <textarea class="form-control" placeholder="share something" rows="3" v-model="form.body"></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Post it</button>

    <template v-if="error">
      <p class="error alert alert-danger">{{error}}</p>
    </template>
  </form>
</template>
<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      error: null,
      form: {
        body: null
      }
    };
  },
  methods: {
    ...mapActions({
      createPost: "createPost"
    }),

    async submit() {
      this.error = "";
      if (!this.form.body) {
        // validate input
        this.error = "post required.";
      } else {
        await this.createPost(this.form);
        this.form.body = "";
      }
    }
  }
};
</script>
<style >
.error {
  margin-top: 5px;
}
</style>
