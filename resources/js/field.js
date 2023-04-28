import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-multi-selector', IndexField)
  app.component('detail-multi-selector', DetailField)
  app.component('form-multi-selector', FormField)
})
