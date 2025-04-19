# Changelog

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.


## [2.0.0] - 2025-04-19
### Added
- Type parameter support for `hasMessages(?string $type)` to check for specific message types
- Type filtering in `getMessages(?string $type)` with secure array access
- Nullable type hints for both methods (PHP 7.4+ compatibility)
- Automatic array re-indexing for type-filtered results in `getMessages()`
- Added XSS protection with explicit `htmlspecialchars()` flags and encoding
- New documentation examples in README for type-filtered messages

### Changed
- **[Breaking]** `hasMessages()` signature changed to accept nullable string parameter
- **[Breaking]** `getMessages()` now returns re-indexed arrays when filtering by type
- Improved type safety with explicit array type checking in closures

### Fixed
- Potential undefined index warnings when checking message types
- Edge cases where null/empty types might cause incorrect results
- Strict type comparison for message type matching


## [1.0.0] - 2025-01-03
### Added
- Initial stable release