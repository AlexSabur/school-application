import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    onShow(event) {
        const button = event.relatedTarget

        // const recipient = button.getAttribute('data-bs-message')
        const action = button.getAttribute('data-bs-action')

        this.element.action = action
    }
}
