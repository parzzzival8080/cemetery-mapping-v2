import Landing from "../components/views/Landing.vue";
import Signin from "../components/views/Signin.vue";
import Signup from "../components/views/Signup.vue";


import Scaffold from "../components/views/home/Scaffold.vue";
import Dashboard from "../components/views/home/Dashboard.vue";
import Hospitals from "../components/views/home/Hospital.vue";
import Rooms from "../components/views/home/Room.vue";
import Users from "../components/views/home/User.vue";

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
    { path: "dashboards", name: "Dashboard", components: { default: Dashboard }},
    { path: "hospitals", name: "Hospitals", components: { default: Hospitals }},
    { path: "hospital-rooms", name: "Rooms", components: { default: Rooms }},
    { path: "users", name: "Users", components: { default: Users }},
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
//   subsriberRoutes,

  // Sample Route For Pusher
  {
      path: "/pusher",
      name: "Pusher",
      component: Pusher
  }
];

export default routes;
