import Vue from "vue";
import VueRouter from "vue-router";

import Referencia from "@/js/components/Referencia";
import Seguimiento from "@/js/components/Seguimiento";
import Reporte from "@/js/components/Reporte";
import Configuracion from "@/js/components/Config";

Vue.use(VueRouter);

const routes = [
  {
    path: "/app/layout",
    name: "",
    component: () => import("./views/App.vue")
  },
  {
    path: "/app/layout/referencia",
    name: "referencia",
    component: Referencia
  },
  {
    path: "/app/layout/seguimiento",
    name: "seguimiento",
    component: Seguimiento
  },
  {
    path: "/app/layout/reporte",
    name: "reporte",
    component: Reporte
  },
  {
    path: "/app/layout/configuracion",
    name: "configuracion",
    component: Configuracion
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;