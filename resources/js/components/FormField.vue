<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
  <Multiselect
  v-model="value"
  id="field"
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
  }"
/>
    </template>
    </DefaultField>
</template>

<script>
import Multiselect from '@vueform/multiselect'
import axios from 'axios';
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
mixins: [FormField, HandlesValidationErrors], // hello
components: {
      Multiselect,
    },
    data() {
      return {
        value: this.field.resourcer ? JSON.parse(this.field.resourcer) : null, // || [],
      }
    },
    mounted() {
      console.log("We are going to the moon - resourceName");
        console.log(this.resource);
  },
  methods: {
    fill(formData) {
      console.log("FILLLL IT!!!");
  this.fillIfVisible(formData, this.field.attribute, this.value || '')
}
  },
    watch: {
    value: {
      handler(newValue) {
        

        const jsonValue = JSON.stringify(newValue);

        console.log("The json value is: ");
        console.log(jsonValue);

        // Send data to the controller
        axios.post('/nova-vendor/multi-selector/update-multi-selector', {
          resourceId: this.resourceId,
          journey: jsonValue,
          resource: this.resource
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
