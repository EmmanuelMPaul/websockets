<template>
  <div>
    <span class="text-secondary">
      {{ pluralize('like' , post.likes, true)}} from {{ pluralize('person', post.likers.data.length, true)}}
      <template
        v-if="post.user.data.liked"
      >(including you)</template>
    </span>

    <ul class="list-inline mb-0">
      <li class="list-inline-item" v-if="canLike">
        <a href="#" @click.prevent="like">like it</a>
      </li>
    </ul>

  </div>
</template>

<script>
import pluralize from "pluralize";
import { mapActions } from "vuex";
export default {
  props: {
    post: {
      required: true,
      type: Object
    }
  },
  methods: {
    pluralize,
    ...mapActions({
      likePost: "likePost"
    }),
    like() {
      this.likePost(this.post.id);
    }
  },
  computed: {
    canLike() {
        //check if user owns a post then prevent liking
      if (this.post.user.data.owner) {
        return false;
      }
      //check if user can like based on likes limit
      if (this.post.user.data.likes_remaining <= 0) { 
        return false;
      }
      return true;
    }
  }
};
</script>
