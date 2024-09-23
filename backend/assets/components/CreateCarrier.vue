<template>
  <div>
    <h2>Create a new carrier</h2>
    <form @submit.prevent="submitCarrier">
      <div class="form-group">
        <label for="carrierName">Carrier Name:</label>
        <input type="text" v-model="carrierName" id="carrierName" class="form-control" required />
      </div>

      <h3>Pricing Rules</h3>
      <div v-for="(rule, index) in pricingRules" :key="index" class="form-group">
        <label>Type:</label>
        <select v-model="rule.type" class="form-control">
          <option value="fixed">Fixed</option>
          <option value="per_kg">Per Kg</option>
        </select>

        <label>Price:</label>
        <input type="number" v-model="rule.fixedPrice" class="form-control" required />

        <div v-if="rule.type === 'fixed'">
          <label>Weight Limit:</label>
          <input type="number" v-model="rule.weightLimit" class="form-control" required />
        </div>

        <button type="button" class="btn btn-danger" @click="removeRule(index)">Remove Rule</button>
      </div>

      <button type="button" class="btn btn-secondary" @click="addRule">Add Rule</button>
      <button type="submit" class="btn btn-primary">Create Carrier</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      carrierName: '',
      pricingRules: [{ type: 'fixed', fixedPrice: 0, weightLimit: null }],
    };
  },
  methods: {
    addRule() {
      this.pricingRules.push({ type: 'fixed', fixedPrice: 0, weightLimit: null });
    },
    removeRule(index) {
      this.pricingRules.splice(index, 1);
    },
    async submitCarrier() {
      const newCarrier = {
        name: this.carrierName,
        carrierPriceRules: this.pricingRules,
      };

      const response = await fetch('/api/carrier/new', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(newCarrier),
      });

      if (response.ok) {
        alert('Carrier created successfully');
        this.carrierName = '';
        this.pricingRules = [{ type: 'fixed', fixedPrice: 0, weightLimit: null }];
      } else {
        const error = await response.json();
        alert(`Error: ${error.message}`);
      }
    },
  },
};
</script>
