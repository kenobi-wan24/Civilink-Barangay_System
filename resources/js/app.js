import './bootstrap'
import { createApp } from 'vue'
import LoginForm from './components/LoginForm.vue'
import AnnouncementFilter from './components/AnnouncementFilter.vue'
import ResidentFilter from './components/admin/ResidentFilter.vue'


const el = document.getElementById('login-app')
if (el) {
    createApp(LoginForm, {
        loginAction:    el.dataset.loginAction,
        registerAction: el.dataset.registerAction,
        csrf:           el.dataset.csrf,
        serverErrors:   JSON.parse(el.dataset.serverErrors || '{}'),
        regErrors:      JSON.parse(el.dataset.regErrors    || '{}'),
        defaultTab:     el.dataset.defaultTab || 'login',
        old:            JSON.parse(el.dataset.old          || '{}'),
    }).mount(el)
}

// Announcement filter
const filterEl = document.getElementById('announcement-filter')
if (filterEl) {
    createApp(AnnouncementFilter, {
        initialSearch:   filterEl.dataset.search   || '',
        initialCategory: filterEl.dataset.category || '',
        action:          filterEl.dataset.action,
    }).mount(filterEl)
}

// Contact form
const contactEl = document.getElementById('contact-form')
if (contactEl) {
    createApp(ContactForm, {
        action: contactEl.dataset.action,
        csrf:   contactEl.dataset.csrf,
        errors: JSON.parse(contactEl.dataset.errors || '{}'),
        old:    JSON.parse(contactEl.dataset.old    || '{}'),
    }).mount(contactEl)
}

// Dashboard chart
const chartEl = document.getElementById('dashboard-chart')
if (chartEl) {
    createApp(DashboardChart, {
        labels: JSON.parse(chartEl.dataset.labels || '[]'),
        values: JSON.parse(chartEl.dataset.values || '[]'),
    }).mount(chartEl)
}

const residentFilterEl = document.getElementById('resident-filter')
if (residentFilterEl) {
    createApp(ResidentFilter, {
        action:     residentFilterEl.dataset.action,
        initZone:   residentFilterEl.dataset.zone   || '',
        initGender: residentFilterEl.dataset.gender || '',
        initStatus: residentFilterEl.dataset.status || '',
        initSearch: residentFilterEl.dataset.search || '',
    }).mount(residentFilterEl)
}