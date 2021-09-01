import Scaffold from "../components/views/Scaffold.vue";
import Landing from "../components/views/Landing.vue";
import Signin from "../components/views/Signin.vue";
import Signup from "../components/views/Signup.vue";
import Dashboard from "../components/views/Dashboard.vue";
import Hospitals from "../components/views/Hospital.vue";
import Users from "../components/views/User.vue";

// Pusher Component
import Pusher from '../components/views/Pusher.vue';

//Admin Routes
let adminRoutes = {
  path: "/admin",
  component: Scaffold,
  redirect: "/admin/hospitals",
  name: "Components",
  children: [
    // { path: "purchase-histories", name: "Purchase Histories", components: { default: PurchaseHistory }},
    { path: "hospitals", name: "Hospitals", components: { default: Hospitals }},
  ]
};

//Subscriber Routes
let subsriberRoutes = {
    path: "/",
    component: Scaffold,
    redirect: "/dashboard",
    name: "Components",
    children: [
      { path: "/dashboard", name: "Dashboard", components: { default: Dashboard }},
    //   { path: "/contacts", name: "Contacts", components: { default: Contact }},
    ]
  };

const routes = [
  {
    path: "/",
    name: "Landing",
    component: Landing,
  },
  {
    path: "/login",
    name: "Signin",
    component: Signin,
  },
  {
    path: "/register",
    name: "Signup",
    component: Signup,
  },
  adminRoutes,
  subsriberRoutes,

  // Sample Route For Pusher
  {
      path: "/pusher",
      name: "Pusher",
      component: Pusher
  }
];

export default routes;
