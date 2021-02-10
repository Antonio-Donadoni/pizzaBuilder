<template>
   <app-layout>
        <template #header >
            <div class="flex justify-between justify-items-center">               
                <h2 class="font-mono font-semibold text-3xl text-red-600 leading-tight ">
                    STORICO ORDINI
                </h2>
                
            </div>
        </template>
        <div>
       
  <div class="my-2 overflow-x-auto sm-mx-6 lg-mx-8">
    <div class="py-6  align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-red-600 border-red-700">
            <tr>
              <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                DATA 
              </th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                ORDINE
              </th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                STATUS
              </th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                PREZZO TOTALE
              </th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Edit</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="order in orders" :key="order.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">
                      {{order.date}}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                    <div v-for="pizza in order.pizzas" :key="pizza.id">
                        1 X {{pizza.size.name}}, {{pizza.type.name}} con
                        <span v-for="ingredient in pizza.ingredients" :key="ingredient.id">{{ingredient.name}} </span>
                    </div>
                </div>
                
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  {{order.status}}
                </span>
              </td>
              <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                {{order.total_price}} €
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="#" class="text-red-600 hover:text-red-900">Riordina</a>
              </td>
            </tr>

            <!-- More items... -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

        </div>


        
    </app-layout>
    
</template>

<script>

 import AppLayout from '@/Layouts/AppLayout';


export default {

    components: {
        AppLayout

    },

   data() {
       return {
           orders : []
       }
   },

   methods: {
       getOrders() {
            axios.get('/orders')
                .then( response => {
                    
                    this.orders = response.data;
                    
                })
                .catch( error => {
                    console.log(error);
                })         
        }
   },
       created() {
        this.getOrders();
        
    },
}
</script>