import { definePreset } from '@primeuix/themes'
import Aura from '@primeuix/themes/aura'

// Theme B — Indigo & Amber (chosen by the team from 3 proposed palettes).
// The amber accent lives as plain CSS vars in styles/variables.scss since
// PrimeVue's semantic slots only cover primary/surface, not a free accent.
//
// Note: the `surface` scale itself must stay lightest-to-darkest (0..950)
// in BOTH color schemes — Aura's own formField/content/text tokens are what
// pick a low index for backgrounds in light mode and a high index in dark
// mode (see formField.color: '{surface.0}' in dark, '{surface.700}' in
// light). Inverting the scale's own ordering per scheme breaks that wiring
// and produces unreadable text.
const grayScale = {
  0: '#ffffff',
  50: '#f9fafb',
  100: '#f3f4f6',
  200: '#e5e7eb',
  300: '#d1d5db',
  400: '#9ca3af',
  500: '#6b7280',
  600: '#4b5563',
  700: '#374151',
  800: '#1f2937',
  900: '#111827',
  950: '#030712',
}

const IndigoPreset = definePreset(Aura, {
  semantic: {
    primary: {
      50: '#eef2ff',
      100: '#e0e7ff',
      200: '#c7d2fe',
      300: '#a5b4fc',
      400: '#818cf8',
      500: '#6366f1',
      600: '#4f46e5',
      700: '#4338ca',
      800: '#3730a3',
      900: '#312e81',
      950: '#1e1b4b',
    },
    colorScheme: {
      light: { surface: grayScale },
      dark: { surface: grayScale },
    },
  },
})

export default {
  preset: IndigoPreset,
  options: {
    darkModeSelector: '.dark',
    cssLayer: false,
  },
}
