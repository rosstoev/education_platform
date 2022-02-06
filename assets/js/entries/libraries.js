import $ from 'jquery';
window.jQuery = $;
window.$ = $;

import "bootstrap";
import "select2";

import * as moment from 'moment';
window.moment = moment;

import "admin-lte/dist/js/adminlte.min";
import "admin-lte/plugins/datatables/jquery.dataTables.min";
import "admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min";
import "admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min";
import "admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min";
import "admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min";
import "admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min";

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