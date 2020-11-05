<template>
  <v-container
    id="regular-forms"
    fluid
    tag="section"
  >
    <base-v-component
      heading="Forms"
      link="components/forms"
    />
    <base-material-card
      color="success"
      icon="mdi-email"
      title="Stacked Form"
      class="px-5 py-3 mb-10"
    >
      <form-base
        v-model="val"
        :schema="schema"
        :scope="'test-form'"
        :on-submit="submit"
      />
    </base-material-card>
    <v-row>
      <v-col
        cols="12"
        md="6"
      >
        <base-material-card
          color="success"
          icon="mdi-email"
          title="Stacked Form"
          class="px-5 py-3"
        >
          <v-form class="mt-5">
            <v-text-field label="Email Address" />

            <v-text-field
              type="password"
              label="Password"
              class="pt-0"
            />

            <v-checkbox
              label="Subscribe to newsletter"
              class="mt-0"
            />
          </v-form>

          <v-card-actions class="pl-0">
            <v-btn
              color="success"
              min-width="100"
            >
              Submit
            </v-btn>
          </v-card-actions>
        </base-material-card>
      </v-col>

      <v-col
        cols="12"
        md="6"
      >
        <base-material-card
          color="success"
          icon="mdi-email-outline"
          title="Horizontal Form"
          class="px-5 py-3"
        >
          <v-form>
            <v-container fluid>
              <v-row
                class="text-no-wrap"
                align="center"
              >
                <v-col
                  cols="3"
                  class="text-right grey--text"
                >
                  Email
                </v-col>

                <v-col>
                  <v-text-field />
                </v-col>
              </v-row>

              <v-row
                class="text-no-wrap"
                align="center"
              >
                <v-col
                  class="text-right grey--text"
                  cols="3"
                >
                  Password
                </v-col>

                <v-col>
                  <v-text-field
                    type="password"
                    class="pt-0"
                  />
                </v-col>
              </v-row>

              <v-row
                class="text-no-wrap"
                align="center"
                no-gutters
              >
                <v-col cols="3" />

                <v-col>
                  <v-checkbox
                    label="Subscribe to newsletter"
                    class="mt-0"
                  />
                </v-col>
              </v-row>
            </v-container>
          </v-form>

          <v-card-actions>
            <v-btn
              color="success"
              min-width="100"
              class="pl-0"
            >
              Sign In
            </v-btn>
          </v-card-actions>
        </base-material-card>
      </v-col>

      <v-col cols="12">
        <base-material-card
          color="success"
          inline
          title="Form Elements"
          class="px-5 py-3"
        >
          <v-subheader class="display-1 mt-3">
            Text fields
          </v-subheader>

          <v-form class="pt-1">
            <v-text-field
              label="With help"
              outlined
              class="ml-4"
            />

            <v-text-field
              label="Password"
              outlined
              type="password"
              class="ml-4"
            />

            <v-subheader class="display-1 mt-3">
              Checkboxes
            </v-subheader>

            <v-row no-gutters>
              <v-col cols="2">
                <v-checkbox
                  input-value="true"
                  label="On"
                  value
                  class="mt-0 ml-4"
                />
              </v-col>

              <v-col cols="2">
                <v-checkbox
                  label="Off"
                  class="mt-0 ml-4"
                />
              </v-col>

              <v-col cols="4">
                <v-checkbox
                  indeterminate
                  label="Indeterminate"
                  value
                  class="mt-0 ml-4"
                />
              </v-col>
            </v-row>

            <v-row no-gutters>
              <v-col cols="2">
                <v-checkbox
                  disabled
                  input-value="true"
                  label="On Disabled"
                  class="mt-0 ml-4"
                />
              </v-col>

              <v-col cols="4">
                <v-checkbox
                  disabled
                  label="Off Disabled"
                  value
                  class="mt-0 ml-4"
                />
              </v-col>
            </v-row>

            <v-row>
              <v-col
                cols="12"
                lg="3"
              >
                <v-subheader class="display-1 mt-3">
                  Radios
                </v-subheader>

                <v-radio-group
                  column
                  class="ml-4 mt-0"
                >
                  <v-radio
                    label="Column Option 1"
                    value="radio-1"
                  />

                  <v-radio
                    label="Column Option 2"
                    value="radio-2"
                  />
                </v-radio-group>
              </v-col>

              <v-col
                cols="12"
                lg="3"
              >
                <v-subheader class="display-1 mt-3">
                  Inline Radios
                </v-subheader>

                <v-radio-group
                  row
                  class="ml-4 mt-0"
                >
                  <v-radio
                    label="Row Option 1"
                    value="radio-1"
                  />

                  <v-radio
                    label="Row Option 2"
                    value="radio-2"
                  />
                </v-radio-group>
              </v-col>
            </v-row>

            <v-subheader class="display-1 mt-3">
              Switches
            </v-subheader>

            <v-row
              no-gutters
              class="ml-4"
            >
              <v-col cols="2">
                <v-switch
                  input-value="true"
                  label="On"
                  value
                />
              </v-col>

              <v-col cols="2">
                <v-switch label="Off" />
              </v-col>

              <v-col cols="2">
                <v-switch
                  disabled
                  input-value="true"
                  label="On Disabled"
                  value
                />
              </v-col>

              <v-col cols="2">
                <v-switch
                  disabled
                  label="Disabled"
                />
              </v-col>

              <v-col cols="2">
                <v-switch
                  input-value="true"
                  label="Loading"
                  loading="primary"
                  value
                />
              </v-col>
            </v-row>
          </v-form>
        </base-material-card>
      </v-col>

      <v-col cols="12">
        <base-material-card
          color="success"
          inline
          title="Input Variants"
          class="px-5 py-3"
        >
          <v-subheader class="display-1 mt-3">
            Selects
          </v-subheader>

          <v-row
            align="center"
            class="ml-1"
          >
            <v-col
              cols="12"
              sm="6"
            >
              <v-select
                :items="items"
                label="Standard"
              />
            </v-col>

            <v-col
              cols="12"
              sm="6"
            >
              <v-select
                :items="items"
                filled
                label="Filled style"
              />
            </v-col>

            <v-col
              cols="12"
              sm="6"
            >
              <v-select
                :items="items"
                label="Outlined style"
                outlined
              />
            </v-col>

            <v-col
              cols="12"
              sm="6"
            >
              <v-select
                :items="items"
                label="Solo field"
                solo
              />
            </v-col>
          </v-row>

          <v-subheader class="display-1 mt-3">
            Sliders
          </v-subheader>

          <v-slider
            color="secondary"
            prepend-icon="mdi-volume-plus"
            track-color="secondary lighten-3"
            class="ml-4"
          />

          <v-slider
            append-icon="mdi-alarm"
            class="ml-4"
          />

          <v-slider
            v-model="zoom"
            append-icon="mdi-magnify-plus-outline"
            prepend-icon="mdi-magnify-minus-outline"
            class="ml-4"
            @click:append="zoomIn"
            @click:prepend="zoomOut"
          />

          <v-subheader class="display-1 mt-3">
            Textareas
          </v-subheader>

          <v-row class="ml-1">
            <v-col
              cols="12"
              md="6"
            >
              <v-textarea
                name="input-7-1"
                label="Default style"
                value="The Woodman set to work at once, and so sharp was his axe that the tree was soon chopped nearly through."
                hint="Hint text"
              />
            </v-col>
            <v-col
              cols="12"
              md="6"
            >
              <v-textarea
                solo
                name="input-7-4"
                label="Solo textarea"
              />
            </v-col>
            <v-col
              cols="12"
              md="6"
            >
              <v-textarea
                filled
                name="input-7-4"
                label="Filled textarea"
                value="The Woodman set to work at once, and so sharp was his axe that the tree was soon chopped nearly through."
              />
            </v-col>
            <v-col
              cols="12"
              md="6"
            >
              <v-textarea
                outlined
                name="input-7-4"
                label="Outlined textarea"
                value="The Woodman set to work at once, and so sharp was his axe that the tree was soon chopped nearly through."
              />
            </v-col>
          </v-row>
        </base-material-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import FormBase from '@/components/Form/FormBase'

  export default {
    name: 'DashboardFormsRegularForms',
    components: {
      FormBase,
    },
    data: () => ({
      checkbox: true,
      items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
      radioGroup: 1,
      switch1: true,
      zoom: 0,
      val: '',
      files: 'null',
      schema: [
        {
          component: 'text',
          name: 'name',
          type: 'text',
          rule: 'required',
          label: 'Name1',
          value: '22222',
          attributes: {
            dense: true,
            class: '12312312312312',
            'open-on-clear': true,
          },
        },
        {
          component: 'textarea',
          name: 'name2',
          type: 'text',
          label: 'Name',
          rule: 'required',
          value: '1',
        },
        {
          component: 'checkbox',
          label: '1111sdfsdf',
          rule: 'required',
          name: 'name3',
          cols: 6,
          value: '1',
          options: [
            {
              id: '1',
              name: '23',
            },
            {
              id: '2',
              name: '2223',
            },
            {
              id: '32',
              name: '1111',
            },
            {
              id: '33',
              name: '1111',
            },
            {
              id: '34',
              name: '1111',
            },
            {
              id: '35',
              name: '1111',
            },
          ],
        },
        {
          component: 'radio',
          label: 'Names22332',
          name: 'name4',
          rule: 'required',
          value: 1,
          cols: 6,
          options: [
            {
              id: '1',
              name: '23',
            },
            {
              id: '2',
              name: '2223',
            },
          ],
        },
        {
          component: 'treeselect',
          label: '12awad',
          name: 'name1111',
          rule: 'required',
          value: '1',
          attributes: {
            options: [],
            placeholder: '1221212',
          },
          options: [
            {
              id: '1',
              name: '23',
              children: [
                {
                  id: 'm-fries1',
                  name: 'French Fries1',
                }, {
                  id: 'm-cheeseburger1',
                  name: 'Cheeseburger1',
                },
              ],
            },
            {
              id: '2',
              name: '2223',
              children: [
                {
                  id: 'm-fries',
                  name: 'French Fries',
                }, {
                  id: 'm-cheeseburger',
                  name: 'Cheeseburger',
                },
              ],
            },
          ],
        },
        {
          component: 'select',
          label: 'Names22111111332',
          attributes: {
            outlined: true,
            class: '12312312312312',
            'open-on-clear': true,
          },
          name: 'name24',
          rule: 'required',
          value: '1',
          options: [
            {
              id: '1',
              name: '23',
            },
            {
              id: '2',
              name: '2223',
            },
          ],
        },
        {
          component: 'file',
          name: 'attachment',
          rule: 'required',
          label: 'Names111  1111',
          attributes: {
            theme: 'list',
          },
        },
      ],
    }),

    methods: {
      zoomOut () {
        this.zoom = (this.zoom - 10) || 0
      },
      zoomIn () {
        this.zoom = (this.zoom + 10) || 100
      },
      submit ({ resolve }) {
        this.axios.post('http://media-manager.loc/test', this.val)
        resolve()
      },
      test ($event) {
        console.log(this.files)
      },
    },
  }
</script>
