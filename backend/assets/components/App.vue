<template>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-3 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="#" @click.prevent="currentView = 'create-package'">
                Create Package
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" @click.prevent="currentView = 'package-list'">
                View Packages
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" @click.prevent="currentView = 'create-carrier'">
                Create Carrier
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-9 px-4">
        <component :is="currentView"></component>
      </main>
    </div>
  </div>
</template>

<script>
import CreatePackage from './CreatePackage.vue';
import PackageList from './PackageList.vue';
import CreateCarrier from './CreateCarrier.vue';

export default {
  data() {
    return {
      currentView: 'create-package',
    };
  },
  components: {
    'create-package': CreatePackage,
    'package-list': PackageList,
    'create-carrier': CreateCarrier,
  },
};
</script>

<style scoped>
/* Дополнительные стили для оформления */
.sidebar {
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  padding: 20px 0;
}
.main-content {
  margin-left: 300px;
  padding: 20px;
}
</style>
