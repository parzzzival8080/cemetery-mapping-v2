import Landing from "../components/views/Landing.vue";
import Signin from "../components/views/Signin.vue";
import Signup from "../components/views/Signup.vue";

//Admin
import AdminScaffold from "../components/views/admin/Scaffold.vue";
import AdminDashboard from "../components/views/admin/Dashboard.vue";
import AdminHospitals from "../components/views/admin/Hospital.vue";
import AdminRooms from "../components/views/admin/Room.vue";
import AdminUsers from "../components/views/admin/User.vue";
import AdminRequests from "../components/views/admin/Request.vue";

//Hospital
import Scaffold from "../components/views/hospital/Scaffold.vue";
import HospitalDashboard from "../components/views/hospital/Dashboard.vue";
import HospitalRooms from "../components/views/hospital/Room.vue";
import HospitalUsers from "../components/views/hospital/User.vue";
import HospitalRequests from "../components/views/hospital/Request.vue";

// Pusher Component
import Pusher from '../components/views/Pusher.vue';

//Admin Routes
let adminRoutes = {
  path: "/admin",
  component: AdminScaffold,
  redirect: "/admin/hospitals",
  name: "Components",
  children: [
    // { path: "purchase-histories", name: "Purchase Histories", components: { default: PurchaseHistory }},
    { path: "/admin/dashboard", name: "Dashboard", components: { default: AdminDashboard }},
    { path: "/admin/hospitals", name: "Hospitals", components: { default: AdminHospitals }},
    { path: "/admin/hospital-rooms", name: "Rooms", components: { default: AdminRooms }},
    { path: "/admin/room-requests", name: "Requests", components: { default: AdminRequests }},
    { path: "/admin/users", name: "Users", components: { default: AdminUsers }},
  ]
};

//Admin Routes
let hospitalRoutes = {
  path: "/hospital",
  component: AdminScaffold,
  redirect: "/hospital/dashboard",
  name: "Components",
  children: [
    // { path: "purchase-histories", name: "Purchase Histories", components: { default: PurchaseHistory }},
    { path: "/hospital/dashboard", name: "Dashboard", components: { default: HospitalDashboard }},
    { path: "/hospital/rooms", name: "Rooms", components: { default: HospitalRooms }},
    { path: "/hospital/users", name: "Users", components: { default: HospitalUsers }},
    { path: "/hospital/room-requests", name: "Requests", components: { default: HospitalRequests }},

  ]
};

//Subscriber Routes
let subsriberRoutes = {
    path: "/",
    component: Scaffold,
    redirect: "/dashboard",
    name: "Components",
    children: [
    //   { path: "/dashboard", name: "Dashboard", components: { default: Dashboard }},
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
  hospitalRoutes,
//   subsriberRoutes,

  // Sample Route For Pusher
  {
      path: "/pusher",
      name: "Pusher",
      component: Pusher
  }
];

export default routes;
