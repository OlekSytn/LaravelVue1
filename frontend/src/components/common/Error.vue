<template>
  <div>
    <div class="bs-component">
      <div class="alert alert-dismissible alert-danger">
        <button class="close" type="button" data-dismiss="alert">×</button>
        <strong>{{ error }}</strong>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ErrorScreen",
  props: ["error"]
};
</script>

<style>
</style>