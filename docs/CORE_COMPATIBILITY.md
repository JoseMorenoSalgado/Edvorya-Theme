# Moodle Core compatibility surface

## Purpose

`theme_edvorya` uses Boost as its Moodle Core compatibility parent. Edvorya no longer recreates generic Bootstrap/Core presentation contracts that Moodle already maintains upstream.

The compatibility rule is now:

> Boost owns generic Moodle Core compatibility. Edvorya only adds product-specific visual treatment or a targeted override backed by a verified regression.

## Removed standalone compatibility modules

The following modules were removed from the production build after adopting Boost:

- `src/styles/core-utilities.css`;
- `src/styles/core-overlays.css`.

The former standalone sheets were also removed:

- `style/edvorya-compat.css`;
- `style/edvorya-accessibility.css`.

Their generic responsibilities are now inherited from Boost. The accessibility-critical active navigation state that belongs to Edvorya was consolidated into `style/edvorya-shell.css`.

## Retained Edvorya refinements

### `src/styles/moodle-forms.css`

Retained only as an Edvorya visual treatment layer for Moodle forms. Moodle/Boost continue to own form structure, behavior and compatibility.

### `src/styles/filemanager.css`

Retained for targeted Edvorya presentation of File Picker/File Manager surfaces. Moodle/Boost continue to own repository behavior, JavaScript and structural compatibility.

### `src/styles/action-menu.css`

Retained for Edvorya-specific spacing and visual refinement of Core action menus. Dropdown behavior remains owned by Moodle/Boost.

### `src/styles/tertiary-navigation.css`

Retained for the Edvorya presentation of Core tertiary navigation data.

### `src/styles/mobile-navigation.css`

Retained because the Edvorya mobile drawer is a product-specific navigation composition built from Moodle-owned navigation data.

### `style/edvorya-shell.css`

Contains only application-shell refinements: mobile drawer presentation, topbar composition and accessibility-critical states belonging to Edvorya.

## Layout compatibility

Edvorya delegates technical/minimal layouts directly to Boost:

- popup;
- frametop;
- embedded;
- maintenance;
- print;
- redirect;
- secure.

The mapping is explicit in `config.php`, preserving compatibility with the Moodle 5.0 layout model while also working on Moodle 5.1 and 5.2.

## Design rule

A new Core-targeted rule may be added only when one of these conditions is true:

1. It changes the visible component into the Edvorya Design System without replacing Core behavior.
2. A supported Moodle/plugin surface demonstrates a concrete regression that Boost does not already solve.
3. Browser or accessibility testing provides reproducible evidence for the rule.

Do not recreate generic Bootstrap utilities, modal mechanics, dropdown visibility logic or Core popover positioning inside Edvorya.

## Performance rule

- Boost compatibility is reused instead of duplicated.
- Tailwind remains build-time only.
- No external stylesheet CDN is required.
- Edvorya production CSS contains product-specific visual rules, not a second Core framework.
- New compatibility code must be measured against CSS weight and maintenance cost.

## Validation

Compatibility changes must pass:

- Moodle 5.0/5.1/5.2 matrix;
- browser functional acceptance;
- responsive acceptance;
- Axe accessibility;
- bundled plugin compatibility;
- required Google Drive plugin compatibility.

Real Safari/iPhone, SCORM and deterministic LTI validation remain environment-specific gates.
