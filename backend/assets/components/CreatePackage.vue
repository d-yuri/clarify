<template>
  <div>
    <h2>Create a new package</h2>
    <form @submit.prevent="submitPackage">
      <div class="form-group">
        <label for="weight">Weight (kg):</label>
        <input type="number" v-model="weight" id="weight" class="form-control" required />
      </div>

      <div class="form-group">
        <label for="carrier">Carrier:</label>
        <select v-model="carrierId" id="carrier" class="form-control" required>
          <option disabled value="">Please select one</option>
          <option v-for="carrier in carriers" :key="carrier.id" :value="carrier.id">
            {{ carrier.name }}
          </option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Create Package</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      weight: '',
      carrierId: '',  // Изменено с carrier на carrierId
      carriers: [],
    };
  },
  mounted() {
    this.fetchCarriers();
  },
  methods: {
    async fetchCarriers() {
      const response = await fetch('/api/carrier');
      this.carriers = await response.json();
    },
    async submitPackage() {
      const newPackage = {
        weight: this.weight,
        carrier: this.carrierId,  // Используем carrierId вместо carrier.name
      };

      const response = await fetch('/api/package/new', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(newPackage),
      });

      if (response.ok) {
        alert('Package created successfully');
        this.weight = '';
        this.carrierId = '';  // Обнуляем carrierId
      } else {
        const error = await response.json();
        alert(`Error: ${error.message}`);
      }
    },
  },
};
</script>
