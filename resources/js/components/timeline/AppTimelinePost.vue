<template>
  <div class="timeline__post media">
    <img src class="timeline__avatar mr-3 rounded" alt />
    <div class="media-body">
      <div class="font-weight-bold">Emmanuel Paul</div>
      <p>What do we say to the God of Death? Not today</p>

      <app-timeline-post-likes />
    </div>
  </div>
</template>
<style>
.timeline__post {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  margin-bottom: 20px;
}
.timeline__avatar {
  width: 60px;
}
</style>
