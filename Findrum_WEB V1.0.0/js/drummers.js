"use strict"

const apiBasis = "http://127.0.0.1:8000/api/"
const routeDrummers = "drummers/"
const routeComponents = "onderdelen/"
const routeBrands = "merken/"

const apiLogin = apiBasis + "login"
const apiRegister = apiBasis + "register"

const deleteComponent = async (id) => {
    try {
        console.log(`Deleting component ${id}...`)
        const response = await axios.delete(apiBasis + routeComponents + id, { 
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization':'Bearer '+ accessToken 
            } 
        })
        if (response.status == 200) {
            return true
        }
        else {
            console.log('Unexpected result, status code: ', response.status)
            return false
        }
    } catch (error) {
        console.log("Unexpected result.", error)
        return false
    } 
}

/**
 * Changes the style of a selected button.
 * @param {Element} button 
 * @returns {void}
 */
const select = (button) => {
    if (button != null && button != undefined) {
        document.querySelectorAll(".selectButton").forEach(selectButton => {
            selectButton.className = "selectButton"
        })
        button.className += " selected"
    }
}

const app = Vue.createApp({
    data(){
        return{
            // Properties
            user: {email: "root@development.com", password: "-2c@BPJ8:WmFfSk5JF+$(/R5e-GEfph,cVWjM8X8"},
            accessToken: undefined,
            selectedDrummer: {"id": 0, "first_name": "", "last_name": ""},
            newDrummer: {"id": 0, "first_name": "", "last_name": ""},
            newComponent: {"name": "", "diameter": 0, "brand": undefined},
            strSearch: "",

            // Requirements for validation
            requirementsDrummer: {
                "first_name_nullable":  false, "first_name_max_char":   75,
                "last_name_nullable":   false, "last_name_max_char":    75,
                "full_name_unique":     true,
            },
            requirementsComponent: {
                "name_nullable":        false, "name_max_char": 100, 
                "diameter_nullable":    false,
                "brand_id_nullable":    false,
                "fully_unique":         true,
            },
        
            // Database values
            DBdrummers: [],
            DBbrands: [],

            // Visable values
            drummers: [],
            components: [],

            // Error messages
            errormessageCreateComponent: "",

            // Styles
            formStyle: {display: "none"},
            loginFormStyle: {display: "inline"},
            secondaryFormStyle: {display: "none"},
            deleteButtonStyle: {display: "none"},
        }
    },
    methods:{
        /**
         * Collects all objects from the database that are usefull or necessary at the beginning.
         * @returns {void}
         */
        async load() {
            let DBbrands = this.DBbrands
            let DBdrummers = this.DBdrummers
            let drummers = this.drummers

            try {
                const responseDrummers = await axios.get(apiBasis + routeDrummers)

                DBdrummers = await responseDrummers.data
                drummers = DBdrummers

                console.log(DBdrummers.length + " drummers loaded.")
            } catch (error) {
                DBdrummers = []
                alert("Drummers konden niet geladen worden.")

                console.log("0 drummers loaded, because of caught error.", error)
            }

            try {
                const responseBrands = await axios.get(apiBasis + routeBrands)
                DBbrands = await responseBrands.data
        
                console.log(DBbrands.length + " brands loaded.")
            } catch (error) {
                DBbrands = []
                alert("Merken konden niet geladen worden.")

                console.log("0 brands loaded, because of caught error.", error)
            }

            this.DBbrands = DBbrands
            this.DBdrummers = DBdrummers
            this.drummers = drummers
        },
        
        /**
         * Collects all the objects linked to the selected object form the database.
         * @returns {void}
         */
        async loadComponents() {
            const selectedDrummer = this.selectedDrummer
            let components = this.components

            try {
                if (selectedDrummer.id == 0) {
                    components = []

                    console.log("0 components loaded, because, no drummer selected.")
                }
                else {
                    const response = await axios.get(apiBasis + routeDrummers + `${selectedDrummer.id}/` + routeComponents)
                    components = await response.data
                    
                    console.log(components.length + " components loaded.")    
                }
            } catch (error) {
                components = []
                alert("Onderdelen konden niet geladen worden.")

                console.log("0 components loaded, because of caught error.", error)
            } 
        
            this.components = components
        },

        /**
         * Adds an object to the database using the text from the create form, if the API allows it.
         * @returns {void}
         */
        async addComponent() { // ------------------------------------- Link to drummer?
            let accessToken = this.accessToken
            let newComponent = this.newComponent

            try {
                if (this.validateComponent(newComponent)) {
                    console.log("No component added, because of bad data. (Missing / Unusable)")
                }
                else {
                    const jsonstring = { 
                        "name": newComponent.name, 
                        "diameter": newComponent.diameter, 
                        "brand_id": newComponent.brand.id, 
                    }
                    const response = await axios.post(apiBasis + routeComponents, jsonstring, { 
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization':'Bearer '+ accessToken 
                        } 
                    })
                    if (response.status == 201) {
                        accessToken = await response.data.access_token
                        console.log("Component added.", newComponent)
                        newComponent = {"name": "", "diameter": 0, "brand": undefined}
                    }
                    else {
                        console.log('No component added, because of wrong status code.', response.status)
                    }
                }
            } catch (error) {
                console.log("No component added, because of caught error.", error)
            } 

            this.accessToken = accessToken
            this.newComponent = newComponent
            this.loadComponents()
        },

        /**
         * Adds an object to the database using the text from the create form, if the API allows it.
         * @returns {void}
         */
        async addDrummer() {
            let accessToken = this.accessToken
            let DBdrummers = this.DBdrummers
            let newDrummer = this.newDrummer
            let errormessageCreateComponent = this.errormessageCreateComponent

            try {
                if (this.validateDrummer(newDrummer)) {
                    const jsonstring = { 
                        "first_name": newDrummer.first_name, 
                        "last_name": newDrummer.last_name 
                    }
                    const response = await axios.post(apiBasis + routeDrummers, jsonstring, { 
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization':'Bearer '+ accessToken 
                        } 
                    })
                    if (response.status == 201) {
                        accessToken = await response.data.access_token

                        const newResponse = await axios.get(apiBasis + routeDrummers)
                        DBdrummers = await newResponse.data

                        console.log(`Added drummer ${newDrummer.first_name} ${newDrummer.last_name}.`)
                        newDrummer = {"id": 0, "first_name": "", "last_name": ""}
                    }
                    else {
                        console.log('No drummer added, because of wrong status code: ', response.status)
                        errormessageCreateComponent = "Couldn't add drummer for unknown reasons. Please refresh the page, and try again."
                    }
                }
                else {
                    console.log("No drummer added, because of bad data. (Missing / Unusable)")
                    errormessageCreateComponent = "Please fill all the fields, and check if this drummer already exists."
                }
            } catch (error) {
                console.log("No drummer added, because of caught error.", error)
                errormessageCreateComponent = "Couldn't add drummer for unknown reasons. Please refresh the page, and try again."
            }

            this.errormessageCreateComponent = errormessageCreateComponent
            this.accessToken = accessToken
            this.DBdrummers = DBdrummers
            this.newDrummer = newDrummer
            this.index()
        },

        /**
         * Edits an object in the database using the text from the edit form, if the API allows it.
         * @returns {void}
         */
        async editDrummer() {
            const selectedDrummer = this.selectedDrummer
            let accessToken = this.accessToken
            let DBdrummers = this.DBdrummers

            try {
                if (!this.validateDrummer(selectedDrummer)) {
                    console.log("No drummer updated, because of bad data. (Missing / Unusable)")
                }
                else {
                    const jsonstring = { 
                        "first_name": selectedDrummer.first_name, 
                        "last_name": selectedDrummer.last_name 
                    }
                    const response = await axios.patch(apiBasis + routeDrummers + selectedDrummer.id, jsonstring, { 
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization':'Bearer '+ accessToken 
                        } 
                    })
                    if (response.status == 200) {

                        accessToken = await response.data.access_token
                        const index = DBdrummers.findIndex(DBdrummer => DBdrummer.id == selectedDrummer.id)
                        DBdrummers[index] = selectedDrummer

                        console.log("Updated drummer.", selectedDrummer)
                    }
                    else {
                        console.log('No drummer updated, because of wrong status code.', response.status)
                    }
                }
            } catch (error) {
                console.log("No drummer updated, because of caught error.", error)
            }         

            this.accessToken = accessToken
            this.DBdrummers = DBdrummers
            this.index()
        },
        
        /**
         * Deletes an object from the database, if the API allows it.
         * @returns {void}
         * @param {object} drummer 
         */
        async deleteDrummer(drummer) {
            let accessToken = this.accessToken
            let DBdrummers = this.DBdrummers

            try {
                const response = await axios.delete(apiBasis + routeDrummers + drummer.id, { 
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization':'Bearer '+ accessToken 
                    } 
                })
                if (response.status == 200) {
                    accessToken = await response.data.access_token
                    DBdrummers = DBdrummers.filter(DBdrummer => DBdrummer !== drummer)
                    console.log("Deleted drummer.", drummer)        
                }
                else {
                    console.log('No drummer deleted, because of wrong status code.', response.status)
                }
            } catch (error) {
                console.log("No drummer deleted, because of caught error.", error) 
            }         

            this.DBdrummers = DBdrummers
            this.accessToken = accessToken   
            this.deSelect()
            this.index()
        },

        /**
         * Logges in the user using the text from the log in form. 
         * If log in is succesfull, this sets the access token, and showes the right forms.
         * @returns {void}
         */
        async login() {
            const user = this.user
            const selectedDrummer = this.selectedDrummer
            let accessToken = this.accessToken
            let formStyle = this.formStyle
            let secondaryFormStyle = this.secondaryFormStyle
            let loginFormStyle = this.loginFormStyle
            let deleteButtonStyle = this.deleteButtonStyle

            const jsonstring = {"password": user.password, "email": user.email}
        
            try {
                const response = await axios.post(apiLogin, jsonstring, {headers: {'Content-Type': 'application/json'}})

                if (response.status == 200) {
                    accessToken = await response.data.access_token
                    console.log('Logged in. Access token: ', accessToken) 

                    loginFormStyle = {display: "none"}
                    formStyle = {display: "inline"}
                    deleteButtonStyle = {display: "inline"}
                    if (selectedDrummer.id != 0) {
                        secondaryFormStyle = {display: "inline"}
                    }
                }
                else {
                    console.log("Unable to log in, because of wrong status code.", response.status)
                }
            } catch (error) {
                console.log("Unable to log in, because of caught error.", error)
            }

            this.accessToken = accessToken
            this.formStyle = formStyle
            this.secondaryFormStyle = secondaryFormStyle
            this.loginFormStyle = loginFormStyle
            this.deleteButtonStyle = deleteButtonStyle
        }, 

        /**
         * Fills the table with the right data using the text in the searchbar.
         * @returns {void}
         */
        index(){
            const strSearch = this.strSearch
            let DBdrummers = this.DBdrummers
            let drummers = this.drummers

            if (strSearch == "") {
                drummers = DBdrummers
            }
            else {
                drummers = []
                strSearch.split(" ").forEach(searchWord => {
                    DBdrummers.forEach(drummer => {
                        if ((drummer.first_name.toLowerCase().includes(searchWord.toLowerCase()) 
                            || drummer.last_name.toLowerCase().includes(searchWord.toLowerCase())) 
                            && searchWord != "") {
                            drummers.push(drummer)
                            DBdrummers = DBdrummers.filter(arrDrummer => arrDrummer !== drummer)
                            
                            return
                        }
                    })
                })
            }
            
            console.log(drummers.length + " drummers found.")
            
            // Do not set this.DBdrummers here.
            this.drummers = drummers
        },

        /**
         * Selects a certain row in the table.
         * @returns {void}
         * @param {object} drummer
         */
        select(drummer) {
            const accessToken = this.accessToken
            let selectedDrummer = this.selectedDrummer
            let secondaryFormStyle = this.secondaryFormStyle

            selectedDrummer = drummer
            
            if (accessToken != undefined) {
                secondaryFormStyle = {display: "initial"}
            }

            this.selectedDrummer = selectedDrummer
            this.secondaryFormStyle = secondaryFormStyle
            this.loadComponents()
        },

        /**
         * Deselects all rows in the table.
         * @returns {void}
         */
        deSelect() {
            let selectedDrummer = this.selectedDrummer
            let secondaryFormStyle = this.secondaryFormStyle

            selectedDrummer = {"id": 0, "first_name": "", "last_name": ""}
            document.querySelectorAll(".selectButton").forEach(selectButton => {
                selectButton.className = "selectButton"
            })

            secondaryFormStyle = {display: "none"}
            
            this.secondaryFormStyle = secondaryFormStyle
            this.selectedDrummer = selectedDrummer
            this.loadComponents()
        },

        /**
         * Validate if all the data of a drummer object is usable for the API. 
         * Returns:
         * - true, if data is usable.
         * - false, if data is unusable. 
         * @return {boolean}
         * @param {object} drummer 
         */ 
        validateDrummer(drummer) {
            const requirements = this.requirementsDrummer
            const DBdrummers = this.DBdrummers

            let unique = true
            if (requirements.full_name_unique) {
                DBdrummers.forEach(DBdrummer => {
                    if (DBdrummer.first_name.toLowerCase() == drummer.first_name.toLowerCase() && DBdrummer.last_name.toLowerCase() == drummer.last_name.toLowerCase()) {
                        unique = false
                        return
                    }
                })
            }

            try {
                return (requirements.first_name_nullable || (drummer.first_name != undefined && drummer.first_name != "" && drummer.first_name != null)) &&
                    drummer.first_name.length <= requirements.first_name_max_char &&
                    (requirements.last_name_nullable || (drummer.last_name != undefined && drummer.last_name != "" && drummer.last_name != null)) &&
                    drummer.last_name.length <= requirements.last_name_max_char &&
                    unique
                } catch (error) {
                console.log("Caught error while validating drummer.", error)
                return false
            }
        },

        /**
         * Validate if all the data of a component object is usable for the API. 
         * Returns:
         * - true, if data is usable.
         * - false, if data is unusable. 
         * @return {boolean}
         * @param {object} component 
        **/ 
        validateComponent(component) {
            const requirements = this.requirementsComponent
            const DBcomponents = this.DBcomponents

            let unique = true
            if (requirements.fully_unique) {
                DBcomponents.forEach(DBcomponent => {
                    if (DBcomponent.name.toLowerCase() == component.name.toLowerCase() && DBcomponent.diameter == component.diameter && DBcomponent.brand_id == component.brand_id) {
                        unique = false
                        return
                    }
                })
            }

            try {
                return (requirements.name_nullable || (component.name != undefined && component.name != "" && component.name != null)) &&
                component.name.length <= requirements.name_max_char &&
                (requirements.diameter_nullable || (component.diameter != undefined && component.diameter != null && component.diameter != "" &&
                !isNaN(component.diameter) && parseInt(Number(component.diameter)) == component.diameter && !isNaN(parseInt(component.diameter, 10)))) &&
                (requirements.brand_id_nullable || (component.brand.id != undefined && component.brand.id != "" && component.brand.id != null && 
                component.brand.id >= 1 && !isNaN(component.brand.id) && parseInt(Number(component.brand.id)) == component.brand.id && !isNaN(parseInt(component.brand.id, 10)))) &&
                unique
            } catch (error) {
                console.log("Caught error while validating component.", error)
                return false
            }
        }
    },
    created: function() {
        this.load()
    }
})

app.mount('main')