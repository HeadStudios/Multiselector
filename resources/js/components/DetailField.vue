<template>
  <div class="flex flex-col md:flex-row -mx-6 px-6 py-2 md:py-0 space-y-2 md:space-y-0" dusk="journey">
    <div class="md:w-1/4 md:py-3"><h4 class="font-normal">
        <span>Journey</span>
    </h4>
</div>
<div class="md:w-3/4 md:py-3 break-all lg:break-words">
  <Multiselect
  v-model="value"
  class="custom-multiselect"
  mode="tags"
  :close-on-select="true"
  :options="{
    '1. Bait Tasted' : '1. Bait Tasted',
    '1.3. UEC' : '1.3. UEC',
    '2. Props Sent' : '2. Props Sent',
    '3. Appointment Set' : '3. Appointment Set',
    '4. Audit Sent' : '4. Audit Sent',
    '5. LP Hook' : '5. LP Hook',
    '5.5. Presentation Made' : '5.5. Presentation Made',
    '6. Pricing Sent' : '6. Pricing Sent',
    'A. Link Clicked' : 'A. Link Clicked',
    'E. Hot Lead' : 'E. Hot Lead',
    '7. Appointment Attended' : '7. Appointment Attended',
    'IOI. Price Request' : 'IOI. Price Request',
    'IOI. Timeline Request' : 'IOI. Timeline Request',
    'IOI. Opt in' : 'IOI. Opt in',
    '54' : 'Incredible assembly'
  }"
  @click.native.stop
/>
</div>
</div>
</template>

<script>
import Multiselect from '@vueform/multiselect'
import axios from 'axios';


export default {
props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
components: {
      Multiselect,
    },
    data() {
      return {
        value: this.field.resourcer ? JSON.parse(this.field.resourcer) : null, // || [],
        options: [
          'Batman',
          'Robin',
          'Joker',
        ]
      }
    },
    mounted() {
      
  },
    watch: {
    value: {
      handler(newValue) {
        
          console.log("About to set some amazing value...");
        const jsonValue = JSON.stringify(newValue);

        console.log("The json value is: ");
        console.log(jsonValue);

        // Send data to the controller
        axios.post('/nova-vendor/multi-selector/update-multi-selector', {
          resourceId: this.resourceId,
          journey: jsonValue,
          resource: this.resourceName
        })
        .then(response => {
          Nova.success("Field updated");
        console.log(response.data.message);
        Nova.success(response.data.message);
        })
        .catch(error => {
        console.error(error);
        Nova.error('Error updating the field');
        }); 

        
       
        
        
      },
      deep: true,
    },
  },
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
