<template>
  <div>
    <h2>Packages List</h2>
    <ul class="list-group">
      <li v-for="packag in packages" :key="packag.id" class="list-group-item">
        ID: {{ packag.id }}, Weight: {{ packag.weight }} kg, Carrier: {{ packag.carrier }}, Price: {{ packag.price }} EUR
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      packages: [],
    };
  },
  mounted() {
    this.fetchPackages();
  },
  methods: {
    async fetchPackages() {
      const response = await fetch('/api/package');
      this.packages = await response.json();
    },
  },
};
</script>
