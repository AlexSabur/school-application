// import * as bootstrap from "bootstrap"
// import * as Turbo from "@hotwired/turbo"

// Turbo.session.drive = false

import { Application } from "@hotwired/stimulus"
import { definitionsFromContext } from "@hotwired/stimulus-webpack-helpers"

// window.bootstrap = bootstrap
window.Stimulus = Application.start()

window.Stimulus.debug = true

const context = require.context("./controllers", true, /\.js$/)
Stimulus.load(definitionsFromContext(context))


