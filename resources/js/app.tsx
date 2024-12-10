import './bootstrap';

import {createInertiaApp} from '@inertiajs/react'
import {createRoot} from 'react-dom/client'

createInertiaApp({
    title: () => 'CAME Connect',
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.tsx', {eager: true})
        return pages[`./Pages/${name}.tsx`]
    },
    setup({el, App, props}) {
        const root = createRoot(el)
        root.render(<App {...props} />)
    },
})