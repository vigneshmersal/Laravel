# Tailwind
https://github.com/tailwindcomponents/dashboard

## Free Templates
https://blocks.wickedtemplates.com/right-headers

## Config
tailwind.config.js
> npx tailwindcss init
> npx tailwindcss init --full
Package.json
> "build-css" : tailwindcss build src/styles.css -o public/styles.css
Build
> npm run build-css

---

## Device Size
> sm, md, lg, xl

## Special Features
> sm:hover: , focus:

---

## Font

## Font Style
Import google font - https://fonts.google.com/specimen/Nunito?sidebar.open=true&selection.family=Nunito:ital,wght@0,200;0,300;1,200
> font-sans (default), font-serif, font-mono

### Font weight
> font-bold, font-light, font-semibold

### Font Case sensitive
> uppercase

### Font size
https://tailwindcss.com/docs/font-size
> text-xs, text-sm, text-base, text-lg, text-xl to text-6xl

### Font color
https://tailwindcss.com/docs/customizing-colors#default-color-palette
> text-red-100 to text-red-900
other colors- teal, indigo, purple, pink

---

## Border

### Border Radius
https://tailwindcss.com/docs/border-radius
default - 0.25rem , .rounded-{t|r|b|l}{-size?}, .rounded-{tl|tr|br|bl}{-size?}
> .rounded-none, .rounded, .rounded-sm, .rounded-full, .rounded-t-none, .rounded-t-sm,
> .rounded-t, .rounded-t-full, .rounded-tl-none, .rounded-tl-sm, .rounded-tl, .rounded-tl-full

### Border Width
https://tailwindcss.com/docs/border-width
default size 1px, specify size-0,2,4,8
> border, border-t, border-b, border-r, border-l
> border-0, border-t-0, border-b-0, border-r-0, border-l-0

### Border Color
https://tailwindcss.com/docs/border-color
> .border-transparent, .border-current, .border-black, .border-white, .border-gray-100

### Border opacity
Changing opacity - 0,25,50,75,100
> border-opacity-0

### Border Style
> .border-solid, .border-dashed, .border-dotted, .border-double, .border-none

---

## Border Divide

### Border Divide Width
direction - x, y , width - 0,2,4,8 , default - 1px
> .divide-x, .divide-y, .divide-x-0, .divide-y-reverse

### Border Divide Color
> .divide-transparent, .divide-current, .divide-black, .divide-gray-100

### Border Divide opacity
Changing opacity - 0,25,50,75,100
> .divide-opacity-0

### Border Divide Style
> .divide-solid, .divide-dashed, .divide-dotted, .divide-double, .divide-none

---

## Space

### Padding
https://tailwindcss.com/docs/padding
0,1,2,3,4,5,6,8,12,16,20,24,32,40,48,56,64, rem
> .p-0, .py-0, .pt-0
1 px
> .p-px, .py-px (t,b), .px-px (l,r), .pt-px (t), .pr-px (r), .pb-px (b), .pl-px (l)

### Margin
https://tailwindcss.com/docs/margin
0,1,2,3,4,5,6,8,12,16,20,24,32,40,48,56,64, rem
> .m-auto, .mt-auto, .m-px (1px), .m-1, .-m-1 (-rem), .my-0, .mx-1, .-mx-1
> .mx-px (l,r), .my-px (t,b), .mt-px (t)

### Space Between
https://tailwindcss.com/docs/space
> flex, flex-row-reverse
0,1,2,3,4,5,6,8,12,16,20,24,32,40,48,56,64, rem | x-top, y-left
> space-x-0, space-x-reverse, .space-y-px (t-1px), .-space-y-1 (negative)

---

## Sizing

### Width
https://tailwindcss.com/docs/width
> .w-0, w-px, .w-auto, .w-full (100%), .w-screen
> .w-1/6 (16), .w-1/5 (20%), .w-1/4 (25%), .w-1/3 (33%), .w-2/5 (40%), .w-1/2 (50%),
> .w-3/5 (60%), .w-2/3 (66%), .w-3/4 (75%), .w-4/5 (80%),

### Min Width
https://tailwindcss.com/docs/min-width
> .min-w-0, .min-w-full (100%)

### Max Width
https://tailwindcss.com/docs/max-width
> .max-w-none, .max-w-sm, .max-w-full, .max-w-screen-sm

---

## Flex
> flex, justify-start, justify-center, justify-end

