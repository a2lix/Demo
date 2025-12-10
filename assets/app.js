/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css'

import * as Popper from "@popperjs/core"
import { Tab } from 'bootstrap/dist/js/bootstrap.esm.min.js';

// import a2lix_lib from '@a2lix/symfony-collection/dist/a2lix_sf_collection.min'
import a2lix_lib from 'https://esm.run/@a2lix/symfony-collection/dist/a2lix_sf_collection.min';

a2lix_lib.sfCollection.init()

// a2lix_lib.sfCollection.init({
//   entry: {
//     add: {
//         label: 'Ajouter',
//         // customFn: (...args) => console.log('add', args),
//         onAfterFn: (...args) => console.log('add', args),
//     },
//     remove: {
//         label: 'Supprimer',
//         // customFn: (...args) => console.log('remove', args),
//         onAfterFn: (...args) => console.log('remove', args),
//     }
// }}
// )
