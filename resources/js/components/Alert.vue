<template>
  <div v-if="visible" :class="['border-l-4 p-4 mb-4 rounded shadow-md flex justify-between items-center', alertClass]">
    <span>{{ message }}</span>
    <button class="ml-4 text-white font-bold" @click="visible = false">&times;</button>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      default: 'info', 
    },
    duration: {
      type: Number,
      default: 5000, 
    },
  },
  data() {
    return {
      visible: true,
    };
  },
  mounted() {
    if (this.duration > 0) {
      setTimeout(() => {
        this.visible = false;
      }, this.duration);
    }
  },
  computed: {
    alertClass() {
      return {
        'bg-green-500 text-white': this.type === 'success',
        'bg-red-500 text-white': this.type === 'error',
        'bg-yellow-500 text-black': this.type === 'warning',
        'bg-blue-500 text-white': this.type === 'info',
      };
    },
  },
};
</script>