<template>
  <v-app app>
    <v-navigation-drawer app>
      <v-list dense nav>
        <v-list-item v-for="item in items" :key="item.title" :to="item.link" link>
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link @click="Cerrar">
          <v-list-item-icon>
            <v-icon>mdi-help-box</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Cerrar sesion</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar app>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">RyCsoft</v-list-item-title>
          <v-list-item-subtitle>Aplicativo de referencia y contrareferencia</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-app-bar>
    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
    <v-footer app></v-footer>
  </v-app>
</template>

<script>
const axios = require("axios");
export default {
  data() {
    return {
      items: [
        { title: "Referencia", icon: "mdi-view-dashboard", link: "/app/layout/referencia" },
        { title: "Seguimiento", icon: "mdi-image", link: "/app/layout/seguimiento" },
        { title: "Reporte", icon: "mdi-help-box", link: "/app/layout/reporte" },
        { title: "Configuracion", icon: "mdi-help-box", link: "/app/layout/configuracion" },
      ],
      right: null,
    };
  },
  methods: {
    Cerrar() {
      localStorage.removeItem("token");

      this.$router.push('/logout');
    },
  }
};
</script>