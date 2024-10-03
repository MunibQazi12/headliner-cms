<template>
  <Head title="Dashboard" />
  <div class="kt-portlet dashboardMainCart dashboard-kt-portlet">
    <div class="kt-portlet__body kt-portlet__body--fit">
      <div class="dashboard-row">
        <div class="dashboard-col">
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">All Visitors</h4>
                <span class="kt-widget24__stats kt-font-brand">
                  <Link :href="route('admin.users')">{{ userData.user }}</Link>
                </span>
                <span class="kt-widget24__desc grnTxt">
                  + 35% compared to previous 30 days
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="dashboard-col">
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">New Visitors</h4>
                <span class="kt-widget24__stats kt-font-warning">
                  <h4>{{ userData.active_user }}</h4>
                </span>
                <span class="kt-widget24__desc grnTxt">
                  + 75% compared to previous 30 days
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="dashboard-col">
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">Phone Leads</h4>
                <span class="kt-widget24__stats kt-font-danger">
                  <h4>125</h4>
                </span>
                <span class="kt-widget24__desc redTxt">
                  - 7% compared to previous 30 days
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="dashboard-col">
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">Web Leads</h4>
                <span class="kt-widget24__stats kt-font-danger">
                  <h4>255</h4>
                </span>
                <span class="kt-widget24__desc grnTxt">
                  + 45% compared to previous 30 days
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="dashboard-col">
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">Web Orders</h4>
                <span class="kt-widget24__stats kt-font-danger">
                  <h4>1000</h4>
                </span>
                <span class="kt-widget24__desc grnTxt">
                  + 115% compared to previous 30 days
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="dashboard-col">
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">Revenue</h4>
                <span class="kt-widget24__stats kt-font-danger">
                  <h4>$275,000</h4>
                </span>
                <span class="kt-widget24__desc grnTxt">
                  + 85% compared to previous 30 days
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="dashboard-col">
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">Units Sold</h4>
                <span class="kt-widget24__stats kt-font-danger">
                  <h4>225,000</h4>
                </span>
                <span class="kt-widget24__desc redTxt">
                  - 3% compared to previous 30 days
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="dashboard-col">
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">Conversion Rate</h4>
                <span class="kt-widget24__stats kt-font-danger">
                  <h4>5.75%</h4>
                </span>
                <span class="kt-widget24__desc grnTxt">
                  + 25% compared to previous 30 days
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div
    class="kt-portlet kt-portlet--mobile dashboard-kt-portlet scnDashboard_wrapper"
  >
    <div class="kt-portlet__body kt-card">
      <div class="row">
        <div class="col-md-6 chart-left">
          <div class="tab-wrapper">
            <h4>Monthly Revenue</h4>
            <div class="chart-wrap">
              <Bar :data="chartData2" :options="lineoptions2" />
            </div>
          </div>
          <div class="row newRow_wrapStyle">
            <div class="col-md-6">
              <div class="kt-widget24">
                <div class="kt-widget24__details">
                  <div class="kt-widget24__info">
                    <h4 class="kt-widget24__title">Monthly Revenue</h4>
                    <span class="kt-widget24__stats kt-font-danger">
                      $275,000
                    </span>
                    <span class="kt-widget24__desc green">
                      +$75,000 this month
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="kt-widget24">
                <div class="kt-widget24__details">
                  <div class="kt-widget24__info">
                    <h4 class="kt-widget24__title">Average Revenue/Customer</h4>
                    <span class="kt-widget24__stats kt-font-danger">
                      $2,500
                    </span>
                    <span class="kt-widget24__desc red">
                      -$500 this month
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 chart-right">
          <div class="table-wrap">
            <h4>Recent Transactions</h4>
            <table>
              <tr>
                <th>Date</th>
                <th>Order #</th>
                <th>Volume (units)</th>
                <th>Revenue</th>
              </tr>
              <tr v-for="n in 15" :key="n">
                <td>05/20/24</td>
                <td>#000150</td>
                <td>15,000</td>
                <td class="green">$15,000.00</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 table-left">
          <div class="table-wrap">
            <h4>Revenue by State</h4>
            <table>
              <tr>
                <th>States</th>
                <th>Sales Orders</th>
                <th>Revenue</th>
              </tr>
              <tr v-for="n in 8" :key="n">
                <td>Texas</td>
                <td>700</td>
                <td>$155,000</td>
              </tr>
            </table>

            <div class="btn-wrap">
              <a class="view-all-btn" href="#url">View All</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 table-right">
          <div class="table-wrap">
            <h4>Revenue by City</h4>
            <table>
              <tr>
                <th>Cities</th>
                <th>Sales Orders</th>
                <th>Revenue</th>
              </tr>
              <tr v-for="n in 8" :key="n">
                <td>Houston, TX</td>
                <td>350</td>
                <td>$75,000</td>
              </tr>
            </table>
            <div class="btn-wrap">
              <a class="view-all-btn" href="#url">View All</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="table-wrap perfomance">
      <h4>Performance</h4>
      <table>
        <tr>
          <th>Source</th>
          <th>Visitors</th>
          <th>New Visitors</th>
          <th>Web Leads</th>
          <th>Rate</th>
          <th>Phone Leads</th>
          <th>Rate</th>
          <th>eCommerce</th>
          <th>Rate</th>
          <th>Revenue</th>
        </tr>
        <tr v-for="n in 8" :key="n">
          <td>Organic</td>
          <td>10,000</td>
          <td>8,000</td>
          <td>1,000</td>
          <td>10%</td>
          <td>300</td>
          <td>3%</td>
          <td>125</td>
          <td>3%</td>
          <td>$350,000</td>
        </tr>
      </table>
    </div>
  </div>
</template>
<script setup>
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  BarElement,
} from "chart.js";

import { ArcElement } from "chart.js";
import { Pie } from "vue-chartjs";
import { onMounted, ref } from "vue";
import { Bar } from "vue-chartjs";

onMounted(() => {
  emit.emit("pageName", "Dashboard", []);
});

ChartJS.register(ArcElement, Tooltip, Legend);

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
);

const props = defineProps(["data"]);
const userData = ref({});
const months = [];
const price = [];
userData.value = props.data;

console.log('props12', props)

const data = {
  labels: ["Active users", "Inactive users"],
  datasets: [
    {
      backgroundColor: ["#41B883", "#E46651"],
      data: [props.data.active_user, props.data.inactive_user],
    },
  ],
};

const lineoptions = {
  responsive: true,
  maintainAspectRatio: false,
};

const lineoptions2 = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      labels: {
        color: "#012060",
      },
    },
  },
};

const chartData = {
  labels: ["A", "B", "C", "A", "B", "C", "A"],
  datasets: [
    {
      label: "Data One",
      backgroundColor: ["#85B6FE", "#506FD9"],
      data: [40, 20, 40, 20, 40, 20, 40, 20],
    },
  ],
};

const chartData2 = {
  labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL"],
  datasets: [
    {
      label: "New Customer",
      backgroundColor: ["rgb(0, 143, 251)"],
      data: [60, 40, 40, 20, 30, 30, 30],
      barThickness: 12,
    },
    {
      label: "Repeat Customer",
      backgroundColor: ["rgb(0, 227, 150)"],
      data: [20, 30, 20, 15, 45, 50, 10],
      barThickness: 12,
    },
  ],
};
</script>
