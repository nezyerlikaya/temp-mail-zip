# Admin Menu: Content

## Purpose

Group content-owning modules without creating a generic page builder.

## Owner Module

Content is a menu group. Individual content types are owned by their modules.

## Visible When

- At least one content owner has a valid visible menu item.
- The user has permission for that owner.

## Contains

- Legal pages from Compliance.
- FAQ/help content from Knowledge Base if enabled.
- Blog posts from Blog if enabled.
- Documentation pages from Documentation if enabled.

## Does Not Contain

- Generic page builder.
- Arbitrary HTML/CSS/JS editor.
- Comments or public discussion system.
- Marketplace/community content.

## Completion Checklist

- [ ] Content group contains only owner-provided children.
- [ ] No generic page builder route exists.
- [ ] No placeholder content module exists.
