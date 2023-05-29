"use strict"
const apiBasis = "http://127.0.0.1:8000/api/"
const addDrummers = "drummers/"
const addComponents = "onderdelen/"
const addBrands = "merken/"
const addBrand = "merk/"

const apiLogin = apiBasis + "login"
const apiRegister = apiBasis + "register"

var drummers = []
var components = []
var brands = []
var selectedDrummer = 0

var loggedIn = false
var access_token = undefined

const loadBrands = async () => {
    console.log('Loading brands...')
    try {
        const response = await axios.get(apiBasis + addBrands)
        const json = await response.data
        let selectBrand = ''
        json.map(el => {
            brands[el.id] = el.name
            selectBrand += `<option value="${el.id}">${el.name}</option>`
        })
        document.getElementById("brand_id").innerHTML = selectBrand
        console.log(json.length + " brands loaded.")
    } catch (error) {
        console.log("Unexpected result.", error)
    }
}

const loadDrummers = async () => {
    console.log('Loading drummers...')
    try {
        const response = await axios.get(apiBasis + addDrummers)
        drummers = await response.data
        console.log(drummers.length + " drummers loaded.")
        return drummers
    } catch (error) {
        console.log("Unexpected result.", error)
    }
    return []
}

const loadComponents = async () => {
    console.log('Loading components...')
    try {
        if (selectedDrummer == 0) {
            console.log("0 components loaded, no drummer selected.")
            components = []
            return
        }

        const response = await axios.get(apiBasis + addDrummers + `${selectedDrummer}/` + addComponents)
        const json = await response.data
        components = []
        json.map(el => {
            components[el.id] = el
        })
        console.log(json.length + " components loaded.")
    } catch (error) {
        console.log("Unexpected result.", error)
    } 
}

const showDrummers = () => {
    console.log("Showing drummers...")
    let tabelInhoud = ''
    if (loggedIn) {
        drummers.map(el => tabelInhoud += `<tr><td class="selectButton" onclick="select(${el.id}, '${el.first_name}', '${el.last_name}', this)">Selecteer</td>
            <td>${el.first_name} ${el.last_name}</td><td onclick="deleteDrummer(${el.id})"> x </td></tr>`)
    }
    else {
        drummers.map(el => tabelInhoud += `<tr><td class="selectButton" onclick="select(${el.id}, '${el.first_name}', '${el.last_name}', this)">Selecteer</td>
            <td>${el.first_name} ${el.last_name}</td><td onclick="deleteDrummer(${el.id})" style="display: none;"> x </td></tr>`)
    }
    if (tabelInhoud == '') {
        tabelInhoud = "Er zijn geen drummers gevonden."
        console.log("No drummers found.")
    }
    else {
        console.log("Succes.")
    }
    document.getElementById("indexDrummers").innerHTML = tabelInhoud
}

const showComponents = async () => {
    console.log("Showing components...")
    let tabelInhoud = ''
    if (loggedIn) {
        components.map(el => tabelInhoud += `<tr><td>${el.name}</td><td>${brands[el.brand_id]}</td>
            <td>${el.diameter}</td><td onclick="deleteComponent(${el.id})""> x </td></tr>`)
    }
    else {
        components.map(el => tabelInhoud += `<tr><td>${el.name}</td><td>${brands[el.brand_id]}</td>
            <td>${el.diameter}</td><td onclick="deleteComponent(${el.id})" style="display: none;"> x </td></tr>`)
    }
    if (tabelInhoud == '') {
        tabelInhoud = "Er zijn geen onderdelen gevonden."
        console.log("No components found.")
    }
    else {
        console.log("Succes.")
    }
    document.getElementById("indexComponents").innerHTML = tabelInhoud
}

const load = async () => {
    await login()
    await loadBrands()
    await loadDrummers()
    await showDrummers()
    showComponents()
}

const login = async () => {
    // const password = document.querySelector("#wachtwoord").value
    // const email    = document.querySelector("#mail").value
    // const jsonstring = {"password":password, "email":email}
    const jsonstring = {"password":"-2c@BPJ8:WmFfSk5JF+$(/R5e-GEfph,cVWjM8X8", "email":"root@development.com"}
    // console.log("login: ", email)
    const respons = await axios.post(apiLogin, jsonstring, {headers: {'Content-Type': 'application/json'}})
    console.log('status code', respons.status)
    access_token = await respons.data.access_token
    console.log('access_token: ', access_token)
    
    document.querySelector("#loginContainer").style.display = "none"
    document.querySelector("#createForm").style.display = "inline"
    document.querySelectorAll("td:last-child").forEach(el => el.style.display = "inline")
    if (selectedDrummer != 0) {
        document.querySelector("#createComponentForm").style.display = "inline"
    }

    loggedIn = true
}		

const select = async (id, firstName, lastName, button) => {
    console.log(`Selecting drummer ${id}...`)
    selectedDrummer = id

    document.querySelectorAll(".selectButton").forEach(selectButton => {
        selectButton.className = "selectButton"
    })
    button.className += " selected"

    if (loggedIn) {
        document.getElementById("updateForm").style.display = "initial"
        document.getElementById("createComponentForm").style.display = "initial"
        document.getElementById("first_nameEdit").value = firstName
        document.getElementById("last_nameEdit").value = lastName
    }

    console.log(`Succes.`)
    await loadComponents()
    showComponents()
}

const deSelect = async () => {
    console.log(`Deselecting all drummers...`)

    selectedDrummer = 0

    document.querySelectorAll(".selectButton").forEach(selectButton => {
        selectButton.className = "selectButton"
    });

    document.getElementById("updateForm").style.display = "none"
    document.getElementById("createComponentForm").style.display = "none"

    console.log('Succes.')
    await loadComponents()
    showComponents()
}

const addDrummer = async () => {
    try {
        const firstName = document.getElementById("first_name").value
        const lastName = document.getElementById("last_name").value
        const jsonstring = { "first_name": firstName, "last_name": lastName }
        console.log("Adding drummer...", jsonstring)
        const response = await axios.post(apiBasis + addDrummers, jsonstring, { 
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization':'Bearer '+ access_token 
            } 
        })
        if (response.status == 201) {
            console.log("Succes.")
        }
        else {
            console.log('Unexpected result, status code: ', response.status)
        }
    } catch (error) {
        console.log("Unexpected result.", error)
    } finally {
        await loadDrummers()
        showDrummers()
    }
}

const addComponent = async () => {
    if (selectedDrummer == 0) {
        console.log("Failed, no drummer selected")
        return
    }
    try {
        const name = document.getElementById("name").value
        const diameter = parseFloat(document.getElementById("diameter").value)
        const brand = parseInt(document.getElementById("brand_id").value)
        const drummer = selectedDrummer
        const jsonstring = { "name": name, "diameter": diameter, "brand_id": brand, "drummer_id": drummer }
        console.log("Adding component...", jsonstring)
        const response = await axios.post(apiBasis + addComponents, jsonstring, { 
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization':'Bearer '+ access_token 
            } 
        })
        if (response.status == 201) {
            console.log("Succes.")
        }
        else {
            console.log('Unexpected result, status code: ', response.status)
        }
    } catch (error) {
        console.log("Unexpected result.", error)
    } finally {
        await loadDrummers()
        await loadComponents()
        await showComponents()
        showDrummers()
    }
}

const deleteDrummer = async (id) => {
    try {
        console.log(`Deleting drummer ${id}...`)
        const response = await axios.delete(apiBasis + addDrummers + id, { 
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization':'Bearer '+ access_token 
            } 
        })
        if (response.status == 200) {
            console.log("Succes.")
        }
        else {
            console.log('Unexpected result, status code: ', response.status)
        }
    } catch (error) {
        console.log("Unexpected result.", error)
    } finally {
        await deSelect()
        await loadDrummers()
        await showComponents()
        showDrummers()
    }
}

const deleteComponent = async (id) => {
    try {
        console.log(`Deleting component ${id}...`)
        const response = await axios.delete(apiBasis + addComponents + id, { 
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization':'Bearer '+ access_token 
            } 
        })
        if (response.status == 200) {
            console.log("Succes.")
        }
        else {
            console.log('Unexpected result, status code: ', response.status)
        }
    } catch (error) {
        console.log("Unexpected result.", error)
    } finally {
        await loadComponents()
        showComponents()
    }
}

const editDrummer = async () => {
    try {
        const first_name = document.getElementById("first_nameEdit").value
        const last_name = document.getElementById("last_nameEdit").value
        const jsonstring = { "first_name": first_name, "last_name": last_name }
        console.log(`Changing drummer ${selectedDrummer} To...`, jsonstring)
        const response = await axios.patch(apiBasis + addDrummers + selectedDrummer, jsonstring, { 
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization':'Bearer '+ access_token 
            } 
        })
        if (response.status == 200) {
            console.log("Succes.")
        }
        else {
            console.log('Unexpected result, status code: ', response.status)
        }
    } catch (error) {
        console.log("Unexpected result.", error)
    } finally {
        await loadDrummers()
        showDrummers()
    }
}

const app = Vue.createApp({                                     // vue-instantie
    data(){                                                     // properties
        return{
            selectedDrummer: {"id": 0, "first-name": "", "lastname": ""},
        
            DBdrummers: loadDrummers(),
            DBcomponents: [],
            DBbrands: [],

            drummers: this.DBdrummers,
            components: this.DBcomponents,

            search: ""
        }
    },
    methods:{                                                   // methods
        SearchDrummers(){
            const DBdrummers = this.DBdrummers
            const search = this.search
            let drummers = this.drummers

            if (search == "") {
                drummers = DBdrummers
            }
            else {
                DBdrummers.forEach(drummer => {
                    // let contains = false
                    search.split(" ").forEach(searchWord => {
                        if (drummer.firstName.includes(searchWord) || drummer.lastName.includes(searchWord)) {
                            // contains = true
                            drummers.add(drummer)
                            return // Test.
                        }
                    })
                })
            }
            
            console.log(drummers.length + "drummers found.")
            
            this.drummers = drummers
        },
        Select() {
            let 
        }
    }
})

app.mount('main')                                               // binding aan html-element