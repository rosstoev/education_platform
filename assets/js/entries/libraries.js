import $ from 'jquery';
window.jQuery = $;
window.$ = $;

import "bootstrap";
import "select2";

import * as moment from 'moment';
window.moment = moment;

import "admin-lte/dist/js/adminlte.min";
import {Calendar} from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import listPlugin from '@fullcalendar/list';
import timeGridPlugin from '@fullcalendar/timegrid';

window.FullCalendar = Calendar;
window.FullCalendarDayGridPlugin = dayGridPlugin;
window.FullCalendarTimeGridPlugin = timeGridPlugin;
window.FullCalendarListPlugin = listPlugin;
window.FullCalendarInteractionPlugin = interactionPlugin;