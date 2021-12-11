# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [6.0.3](https://github.com/loophp/collection/compare/6.0.2...6.0.3)

### Merged

- Fix intersperse operation. [`#226`](https://github.com/loophp/collection/pull/226)

### Commits

- refactor: Improve `Intersperse` operation. [`a208d4c`](https://github.com/loophp/collection/commit/a208d4c8fe4877cff108196f481fdd7935513553)

## [6.0.2](https://github.com/loophp/collection/compare/6.0.1...6.0.2) - 2021-11-30

### Merged

- chore(deps): Bump shivammathur/setup-php from 2.15.0 to 2.16.0 [`#223`](https://github.com/loophp/collection/pull/223)
- chore(deps): Bump actions/cache from 2.1.6 to 2.1.7 [`#222`](https://github.com/loophp/collection/pull/222)
- [PHPStan Baseline] A few small fixes [`#220`](https://github.com/loophp/collection/pull/220)

### Commits

- docs: Add/update CHANGELOG. [`e9373e6`](https://github.com/loophp/collection/commit/e9373e6c19d57acca6aa010cb0dac0e89850ff8f)
- cs: Autofix code style. [`ab5cac3`](https://github.com/loophp/collection/commit/ab5cac3691e42801535ed41d02458e9842daeb61)
- Fix PHP 8.1 Deprecations #225 [`0cb2e0e`](https://github.com/loophp/collection/commit/0cb2e0e336f5d56a70575bf7150d5ac6ea7c8b8e)
- cs: Autofix code style. [`d8d812b`](https://github.com/loophp/collection/commit/d8d812bb413fbcfec44e8bda4a40cbe0b60d9dec)
- sa: Improve static analysis score. [`db0073e`](https://github.com/loophp/collection/commit/db0073e5e1b4cc07f8d88eac2111458ea681a074)

## [6.0.1](https://github.com/loophp/collection/compare/6.0.0...6.0.1) - 2021-11-12

### Merged

- Update docs version [`#219`](https://github.com/loophp/collection/pull/219)
- Template param order matters? [`#218`](https://github.com/loophp/collection/pull/218)

### Commits

- docs: Add/update CHANGELOG. [`3142f23`](https://github.com/loophp/collection/commit/3142f2372144caf4896be1a729e0d905eec58ed9)

## [6.0.0](https://github.com/loophp/collection/compare/5.1.0...6.0.0) - 2021-11-11

### Merged

- [PHPStan Baseline] Fix Errors Part 2 + Modify `Unfold` Operation [`#217`](https://github.com/loophp/collection/pull/217)
- [PHPStan Baseline] Fix a few errors [`#216`](https://github.com/loophp/collection/pull/216)
- Fix/update PHPStan [`#212`](https://github.com/loophp/collection/pull/212)
- Fix `All` operation for standalone usage [`#215`](https://github.com/loophp/collection/pull/215)
- Update `all` operation to prevent data loss [`#209`](https://github.com/loophp/collection/pull/209)
- chore(deps): Bump actions/checkout from 2.3.5 to 2.4.0 [`#214`](https://github.com/loophp/collection/pull/214)
- refactor(groupbyable)!: simplify implementation and update typing info [`#207`](https://github.com/loophp/collection/pull/207)
- feat: Add `Find` operation [`#204`](https://github.com/loophp/collection/pull/204)
- Refactor `Current` operation - Let specify a default value [`#205`](https://github.com/loophp/collection/pull/205)
- chore(deps): Bump actions/checkout from 2.3.4 to 2.3.5 [`#203`](https://github.com/loophp/collection/pull/203)
- fix: Update `Flipable` interface. [`#200`](https://github.com/loophp/collection/pull/200)
- chore(deps): Bump shivammathur/setup-php from 2.14.0 to 2.15.0 [`#197`](https://github.com/loophp/collection/pull/197)

### Commits

- docs: Add/update CHANGELOG. [`a55e97a`](https://github.com/loophp/collection/commit/a55e97a48f7b9f12d77d1644799086f93d126a06)
- Fix ReadTheDocs builds - see readthedocs/readthedocs.org#8616 [`49d1673`](https://github.com/loophp/collection/commit/49d16732949340246233debe8884a0d778561f9e)
- refactor: Simplify `MatchOne` operation - Add missing typing informations. [`f66b407`](https://github.com/loophp/collection/commit/f66b4074f3e46702c30a6dd02909b3991f7a2a22)
- refactor: Simplify `MatchOne` operation. [`1e6ad7a`](https://github.com/loophp/collection/commit/1e6ad7a52128007bc938d59af67ec5fadf1d7e04)
- tests: Add SA tests for `Random` and `Shuffle` operations. [`cefe0f5`](https://github.com/loophp/collection/commit/cefe0f5beeb3e6d6c00f1314cc027b8ffbd04941)
- tests: Add SA tests for `Wrap` operation. [`ef61f57`](https://github.com/loophp/collection/commit/ef61f5708d5e03e0ed26f3961f16142df75cef3b)

## [5.1.0](https://github.com/loophp/collection/compare/5.0.0...5.1.0) - 2021-09-27

### Merged

- Update various typing information [`#196`](https://github.com/loophp/collection/pull/196)
- chore(deps): Bump shivammathur/setup-php from 2.13.0 to 2.14.0 [`#195`](https://github.com/loophp/collection/pull/195)
- refactor: Fix PSalm issues. [`#194`](https://github.com/loophp/collection/pull/194)
- Fix `inits` operation [`#191`](https://github.com/loophp/collection/pull/191)
- refactor: Update `Duplicate` and `Distinct` operations in point free style. [`#188`](https://github.com/loophp/collection/pull/188)
- refactor: Update various operation and typing informations [`#190`](https://github.com/loophp/collection/pull/190)
- refactor: Update `Init` operation in point free style. [`#186`](https://github.com/loophp/collection/pull/186)
- refactor: Update `combine` operation in point free style. [`#187`](https://github.com/loophp/collection/pull/187)
- chore(deps): Bump shivammathur/setup-php from 2.12.0 to 2.13.0 [`#184`](https://github.com/loophp/collection/pull/184)
- refactor: Update `Transpose` operation in point free style. [`#178`](https://github.com/loophp/collection/pull/178)
- refactor: Update `Zip` operation in point free style. [`#181`](https://github.com/loophp/collection/pull/181)
- refactor: Update `Window` operation in point free style. [`#179`](https://github.com/loophp/collection/pull/179)
- fix: Update PHPStan configuration [`#183`](https://github.com/loophp/collection/pull/183)
- refactor: Minor optimizations in various operations. [`#180`](https://github.com/loophp/collection/pull/180)
- refactor: Update `Collapse` operation in point free style. [`#182`](https://github.com/loophp/collection/pull/182)
- refactor: Update cross `product` operation in point free style. [`#177`](https://github.com/loophp/collection/pull/177)

### Commits

- docs: Update CHANGELOG.md. [`05beff2`](https://github.com/loophp/collection/commit/05beff269b96a0069fec9ce2d2f9d9ed079d1323)
- fix: Update `RandomIterator` types. [`5a5ae1d`](https://github.com/loophp/collection/commit/5a5ae1d95c799d4515a69f4f5e1e1b3824fd7c8c)
- fix: Fix `Unpair` operation return types. [`885059f`](https://github.com/loophp/collection/commit/885059fe274ede570aace973c5ed1627e0305d5e)
- fix: Autofix code style. [`08199ca`](https://github.com/loophp/collection/commit/08199ca258fdc750e9a4558d33215547f5f59004)
- Fix interfaces (to backport to master) [`f9b7c1c`](https://github.com/loophp/collection/commit/f9b7c1c3d95937a52172cf272c1ace5f7cc9d98e)
- Fix `Rangeable` interface (to backport to master) [`da430f9`](https://github.com/loophp/collection/commit/da430f9612832e7d04f878a27e6b57a970d2f101)
- Fix `Zipable` interface (to backport to master) [`7e47439`](https://github.com/loophp/collection/commit/7e47439d928e1d77537fad35b7460200a56d88c6)
- Fix `Initsable` interface (to backport to master) [`711f3c7`](https://github.com/loophp/collection/commit/711f3c768f50f3e58a9120b4158e142bff9ee4b9)
- Fix `Groupable` interface (to backport to master) [`6c24b7e`](https://github.com/loophp/collection/commit/6c24b7e56f80322afb1aa19f791bff3dc00af0d5)
- fix: Update return types of `Implode` and `Unlines` operation. [`05bbf8e`](https://github.com/loophp/collection/commit/05bbf8e9fcd7d6f4bfc441636bf4a25d298e89a2)
- refactor: Update `Frequency` operation return type and minor optimizations here and there. [`a1964f4`](https://github.com/loophp/collection/commit/a1964f49547952f8a633ef4cfac017ea05134b31)
- refactor: Update `Transpose` operation in point free style - add missing documentation (#178) [`bd0ec78`](https://github.com/loophp/collection/commit/bd0ec7814e97422bf597baf5edcb2bf91b9fb106)
- tests: Add missing test for the `Window` operation. [`a2ee653`](https://github.com/loophp/collection/commit/a2ee6535812db49aafa7256aa6d9fa517b75f03f)

## [5.0.0](https://github.com/loophp/collection/compare/4.1.0...5.0.0) - 2021-08-06

### Merged

- Documentation: Collection Principles [`#174`](https://github.com/loophp/collection/pull/174)
- Refactor/update `Span` and `Partition` in point-free [`#175`](https://github.com/loophp/collection/pull/175)
- refactor: Update`Distinct` and `Duplicate` operations. [`#168`](https://github.com/loophp/collection/pull/168)
- refactor: Update Unpack operation - do not use MapN. [`#169`](https://github.com/loophp/collection/pull/169)
- refactor: Use ETA Reduction for the Pipe operation. [`#164`](https://github.com/loophp/collection/pull/164)
- refactor: Add missing type hints. [`#171`](https://github.com/loophp/collection/pull/171)
- ci: Enable tests on macOS. [`#170`](https://github.com/loophp/collection/pull/170)
- Update Reject operation - Use Filter based algorithm and point free style. [`#167`](https://github.com/loophp/collection/pull/167)
- Fix Column Typing + SA Check [`#166`](https://github.com/loophp/collection/pull/166)
- SA: Update operations. [`#165`](https://github.com/loophp/collection/pull/165)
- **Breaking change:** refactor: Make constructor private. [`#163`](https://github.com/loophp/collection/pull/163)
- Improve static analysis tests [`#153`](https://github.com/loophp/collection/pull/153)
- chore(deps-dev): Update infection/infection requirement || ^0.24.0 [`#162`](https://github.com/loophp/collection/pull/162)
- feat: Add `::fromGenerator` constructor. [`#150`](https://github.com/loophp/collection/pull/150)
- Temporary workaround until phpstan/phpstan#5372 is fixed. [`#161`](https://github.com/loophp/collection/pull/161)
- Drop accepts non-variadic count [`#157`](https://github.com/loophp/collection/pull/157)
- Add API Docs Description to Interface Methods [`#156`](https://github.com/loophp/collection/pull/156)
- Add Operation: `Same` [`#155`](https://github.com/loophp/collection/pull/155)
- Add `Reduce` operation [`#139`](https://github.com/loophp/collection/pull/139)
- Add `Equals` Operation [`#152`](https://github.com/loophp/collection/pull/152)
- Fix: Prevent warning when using odd amount of items. [`#154`](https://github.com/loophp/collection/pull/154)
- Link to `stable` docs instead of `latest` [`#151`](https://github.com/loophp/collection/pull/151)
- Update Span and Partition operations. [`#148`](https://github.com/loophp/collection/pull/148)
- **Breaking change:** refactor: Reduce the use of the spread operators and variadic parameters. [`#146`](https://github.com/loophp/collection/pull/146)
- refactor: Rename variables and properties. [`#145`](https://github.com/loophp/collection/pull/145)
- chore(deps): Bump actions/stale from 3.0.19 to 4 [`#143`](https://github.com/loophp/collection/pull/143)
- chore(deps): Bump shivammathur/setup-php from 2.11.0 to 2.12.0 [`#144`](https://github.com/loophp/collection/pull/144)
- Add AsyncMapN Operation | Remove AsyncMap Variadic Callbacks Usage [`#141`](https://github.com/loophp/collection/pull/141)
- Add coverage check [`#142`](https://github.com/loophp/collection/pull/142)
- Span: Add Variadic Callback Support [`#140`](https://github.com/loophp/collection/pull/140)
- Update `Reverse` operation - optimize and remove todos. [`#138`](https://github.com/loophp/collection/pull/138)
- Add IsEmpty Operation [`#137`](https://github.com/loophp/collection/pull/137)
- Update Operations Signatures in API Docs [`#136`](https://github.com/loophp/collection/pull/136)
- Add All Operation [`#133`](https://github.com/loophp/collection/pull/133)
- Refactor Scalar Operations [`#132`](https://github.com/loophp/collection/pull/132)
- Update `Map` to only take a single callback [`#134`](https://github.com/loophp/collection/pull/134)
- Provide util class for reducer callback [`#131`](https://github.com/loophp/collection/pull/131)
- Refactor `::partition()` and `::span()` [`#124`](https://github.com/loophp/collection/pull/124)
- Add Collection::isEmpty Method [`#130`](https://github.com/loophp/collection/pull/130)
- Change GitHub Actions Workflow Triggers [`#127`](https://github.com/loophp/collection/pull/127)
- Add `Reject` operation. [`#125`](https://github.com/loophp/collection/pull/125)
- **Breaking change:** Update `Filter` operation. [`#126`](https://github.com/loophp/collection/pull/126)

### Commits

- docs: Add/update CHANGELOG. [`74d3069`](https://github.com/loophp/collection/commit/74d3069331847f625d2ee11e0522777f82666ce0)
- chore: Add AFUP presentation link. [`404d0b7`](https://github.com/loophp/collection/commit/404d0b72e49b0388a89636c82ec04c0d0ff815d9)
- chore: Update Github configuration files. [`c6488a4`](https://github.com/loophp/collection/commit/c6488a475df5fa113e3274d09994f0f22aa6a532)
- Update IfThenElse operation, add missing typing information. [`5f4ef9e`](https://github.com/loophp/collection/commit/5f4ef9e16cc2d82a3ccd3248ac58c63eec9c9856)
- Update IfThenElse operation, add missing typing information. [`ed3c095`](https://github.com/loophp/collection/commit/ed3c095ec607030dfee9987bf1011fbdac5d558c)
- ci: Fix code-style workflow. [`40cc177`](https://github.com/loophp/collection/commit/40cc17728f14ee923d91bcdc50961a21a64f38e1)
- chore: Update composer.json, remove obsolete dependencies. [`d8a8d50`](https://github.com/loophp/collection/commit/d8a8d50ad4d335306212a13c0549c7be3cebb4e1)

## [4.1.0](https://github.com/loophp/collection/compare/4.0.7...4.1.0) - 2021-07-05

### Merged

- Show Collection is Immutable & Operations Pure [`#122`](https://github.com/loophp/collection/pull/122)
- Trim Static Analysis Baselines [`#121`](https://github.com/loophp/collection/pull/121)
- Adding More Static Analysis Checks [`#120`](https://github.com/loophp/collection/pull/120)
- feat: Add Matching operation and implements Selectable from Doctrine. [`#115`](https://github.com/loophp/collection/pull/115)
- Add FlatMap Operation [`#117`](https://github.com/loophp/collection/pull/117)
- Update Distinct operation [`#111`](https://github.com/loophp/collection/pull/111)
- Static Analysis Checks: Common Operations (III) [`#114`](https://github.com/loophp/collection/pull/114)
- Introduce MapN | Deprecate Map With Multiple Callbacks | Static Analysis Checks [`#112`](https://github.com/loophp/collection/pull/112)
- Bump minimum version of phpspec to ^7.1. [`#113`](https://github.com/loophp/collection/pull/113)
- Static Analysis Checks: Common Operations (II) [`#109`](https://github.com/loophp/collection/pull/109)
- Operation Interfaces return Collection Interface [`#108`](https://github.com/loophp/collection/pull/108)
- Static Analysis Checks: Common Operations (I) [`#106`](https://github.com/loophp/collection/pull/106)
- feat: Add When operation. [`#105`](https://github.com/loophp/collection/pull/105)
- Improve Collection Typings + Add `strict` Operation [`#102`](https://github.com/loophp/collection/pull/102)
- PHP 8 Compatibility [`#104`](https://github.com/loophp/collection/pull/104)
- Update Psalm Annotations [`#101`](https://github.com/loophp/collection/pull/101)
- chore(deps): Bump actions/cache from 2.1.5 to 2.1.6 [`#100`](https://github.com/loophp/collection/pull/100)
- SA Checks: Methods Starting with "a" [`#97`](https://github.com/loophp/collection/pull/97)

### Commits

- docs: Add/update CHANGELOG. [`5edb9e7`](https://github.com/loophp/collection/commit/5edb9e793544e71e2ba7d58b9c6c37c9a68cbb5f)
- chore: Update .gitattributes for saving space (and trees). [`c7ba932`](https://github.com/loophp/collection/commit/c7ba9324f4d27cf79d184fb3497b20a1c51b6e5f)
- docs: Minor update in code typing. [`c8ad466`](https://github.com/loophp/collection/commit/c8ad466eb5551e1cd1e082e69cf502d0a54d1bc8)
- Update PSalm and PHPStan baselines. [`58d8035`](https://github.com/loophp/collection/commit/58d803596d7a1de840550f06c491b88c9e944754)
- Add missing Partitionable. [`defb903`](https://github.com/loophp/collection/commit/defb9036bb5fcfdc9ae9889909df464b65dba8c8)
- Fixes & improvements [`77201ba`](https://github.com/loophp/collection/commit/77201baf45cd837f084d74392b456b1c815d6ece)
- test: Add missing test. [`997efd9`](https://github.com/loophp/collection/commit/997efd974d016ca3f762f5068460bc4b880d20ec)
- refactor: Update distinct operation. [`023d399`](https://github.com/loophp/collection/commit/023d399c5fb4767c1585b01775c412686bc1436f)
- tests: Autofix code style. [`366c79b`](https://github.com/loophp/collection/commit/366c79b14e0896a76ab457b9178fc51876b0b5ea)
- tests: Add missing static analysis tests. [`fb641e8`](https://github.com/loophp/collection/commit/fb641e810e69d570f24bbbb4a51da9a482519a10)
- ci: Remove obsolete required status checks. [`6a7f8c5`](https://github.com/loophp/collection/commit/6a7f8c5781f9a21af694e7d9d74f33998a845ff8)
- docs: Add a note on how to extend a Collection. [`9d21114`](https://github.com/loophp/collection/commit/9d21114ef8ab19c514ca3d4c4b842babdb55a312)
- ci: Run static-analysis tools only on Linux platform. [`fb9fcd7`](https://github.com/loophp/collection/commit/fb9fcd735fe36d48693b17545c9c3a0c575df056)
- ci: Do not do unit testing on Darwin platforms. [`8921563`](https://github.com/loophp/collection/commit/8921563a97e9acda6240282712a2e70860f3051b)
- refactor: Fix PHPStan. [`717b364`](https://github.com/loophp/collection/commit/717b364beb4adb49b52128c6d8cad8b4bd7796a7)
- refactor: Fix Applyable type hints. [`cd8ef32`](https://github.com/loophp/collection/commit/cd8ef325ad14c06f28e66247621055d092dfc765)
- docs: Update example. [`3f18553`](https://github.com/loophp/collection/commit/3f1855395c40675e8f9cf3eac070a2a82c867ab4)

## [4.0.7](https://github.com/loophp/collection/compare/4.0.6...4.0.7) - 2021-05-25

### Merged

- SA Checks: fromIterable, empty [`#96`](https://github.com/loophp/collection/pull/96)
- SA Checks: fromCallable [`#94`](https://github.com/loophp/collection/pull/94)
- docs: Add lazy JSON parsing examples using @halaxa JsonMachine library. [`#93`](https://github.com/loophp/collection/pull/93)
- Introduce Static Analysis Checking System [`#90`](https://github.com/loophp/collection/pull/90)
- Code Analysis Fixes - PHPStan [`#89`](https://github.com/loophp/collection/pull/89)
- Update Documentation III [`#88`](https://github.com/loophp/collection/pull/88)
- Update API Documentation II [`#86`](https://github.com/loophp/collection/pull/86)
- chore(deps): Bump actions/stale from 3.0.18 to 3.0.19 [`#87`](https://github.com/loophp/collection/pull/87)
- Feature: Add Squash operation [`#83`](https://github.com/loophp/collection/pull/83)
- Fix CI configuration. [`#85`](https://github.com/loophp/collection/pull/85)
- Update Documentation [`#84`](https://github.com/loophp/collection/pull/84)
- chore(deps): Bump shivammathur/setup-php from 2 to 2.11.0 [`#79`](https://github.com/loophp/collection/pull/79)
- chore(deps-dev): Update infection/infection requirement || ^0.23.0 [`#81`](https://github.com/loophp/collection/pull/81)
- refactor: Remove static factory methods from contract [`#78`](https://github.com/loophp/collection/pull/78)
- Update `drupol/php-conventions` [`#76`](https://github.com/loophp/collection/pull/76)

### Commits

- docs: Update changelog. [`9b986aa`](https://github.com/loophp/collection/commit/9b986aac21c1b7e18fec96075fe1a2ee227d6a0f)
- chore: Add composer commands and necessary files to generate the changelog. [`645930e`](https://github.com/loophp/collection/commit/645930e3b7327862933451ba2af7678b0c16f0c1)
- ci: Update CI configuration. [`3813450`](https://github.com/loophp/collection/commit/38134506c743161385ced57646514ae30a77458b)
- refactor: Autofix code. [`540006b`](https://github.com/loophp/collection/commit/540006bb908ab57a7b43c532958ed857325890fa)
- chore: Update drupol/php-conventions. [`cd50573`](https://github.com/loophp/collection/commit/cd505738bb56e4d2242c52ec71cdb3729df46e1c)

## [4.0.6](https://github.com/loophp/collection/compare/4.0.5...4.0.6) - 2021-04-20

### Commits

- docs: Update changelog. [`a32164e`](https://github.com/loophp/collection/commit/a32164e83e2826dff1959005a1df12e29e0fd4bd)
- fix: Fix Psalm annotations. [`4ace8ef`](https://github.com/loophp/collection/commit/4ace8ef72640423799a365d40245c48aaf986591)

## [4.0.5](https://github.com/loophp/collection/compare/4.0.4...4.0.5) - 2021-04-20

### Commits

- docs: Update changelog. [`a53167d`](https://github.com/loophp/collection/commit/a53167d6995df4b5555d7aafcde15b7d710acd16)
- ci: Update Docker stack - now includes service for creating changelogs. [`228831e`](https://github.com/loophp/collection/commit/228831effa5c680576540495066b291fa871460a)
- refactor: Remove variable assignation. [`afe71bf`](https://github.com/loophp/collection/commit/afe71bf762a35202c53685eb41e43faffd848e07)
- refactor: Update Pipe operation - remove call_user_func. [`d31df6f`](https://github.com/loophp/collection/commit/d31df6fc1a4770731fe1725f9084fa87201721f8)
- feat: Add Coalesce operation. [`6e5c758`](https://github.com/loophp/collection/commit/6e5c758e5f8cc465359737840bf0a5797421965f)
- refactor: Improve Has operation. [`1425343`](https://github.com/loophp/collection/commit/14253435b5577e47ee51753ab1641a7bef8ef745)

## [4.0.4](https://github.com/loophp/collection/compare/4.0.3...4.0.4) - 2021-04-17

### Merged

- chore(deps): Bump actions/cache from v2.1.4 to v2.1.5 [`#75`](https://github.com/loophp/collection/pull/75)

### Commits

- docs: Update changelog. [`583e95b`](https://github.com/loophp/collection/commit/583e95bb06f9e8946534f01b770cebf60c0196f0)
- docs: Update README.md. [`4fa857b`](https://github.com/loophp/collection/commit/4fa857b53d5719a03ec578c4a8c055a39ef89d71)
- chore: Update composer.json - update dev dependencies constraints. [`dbf6441`](https://github.com/loophp/collection/commit/dbf6441ba55b65d23efb014a15565a2e44bb7634)
- refactor: Fix a couple of PSalm issues. [`89db061`](https://github.com/loophp/collection/commit/89db0612ce137355edc4f77473522ff0ca6a645f)
- refactor: Minor update on MatchOne operation. [`b913a6b`](https://github.com/loophp/collection/commit/b913a6b7e1702746fedb9e4fedf5700e43102bca)

## [4.0.3](https://github.com/loophp/collection/compare/4.0.2...4.0.3) - 2021-04-11

### Commits

- docs: Update changelog. [`2a5a141`](https://github.com/loophp/collection/commit/2a5a14143c45bacf1756d5f6efc8c0bf10aa1b15)
- refactor: Update MatchOne operation. [`287b158`](https://github.com/loophp/collection/commit/287b158628619c8248be05cd11541aa1b32529cd)
- tests: Add more tests. [`372b1d1`](https://github.com/loophp/collection/commit/372b1d1907d1a1ce586f5a49bf1fc9568ac67398)
- refactor: Update Every operation. [`e0cc29c`](https://github.com/loophp/collection/commit/e0cc29ce58c49e53965ece1700ff7881a8443937)

## [4.0.2](https://github.com/loophp/collection/compare/4.0.1...4.0.2) - 2021-04-04

### Commits

- docs: Update Changelog. [`e183f29`](https://github.com/loophp/collection/commit/e183f294b860dc409470ad9c154641a4329484b1)
- Revert "refactor: Use call_user_func_array() functions." [`54327af`](https://github.com/loophp/collection/commit/54327afcdcb4a1e8f2d806aa5941ab20a6dcbea3)

## [4.0.1](https://github.com/loophp/collection/compare/4.0.0...4.0.1) - 2021-04-03

### Merged

- collection: implements missing \Countable interface [`#74`](https://github.com/loophp/collection/pull/74)
- Fix minimum PHP version in the readme [`#73`](https://github.com/loophp/collection/pull/73)

### Commits

- docs: Update Changelog. [`78b5e2e`](https://github.com/loophp/collection/commit/78b5e2e26d7ceafe0b65650fac500fc43e3e70d7)
- refactor: Use call_user_func_array() functions. [`614a663`](https://github.com/loophp/collection/commit/614a66349af4e4aea801d5e298e96e99e0918b28)
- refactor: Minor optimization in Window operation. [`1e8de4a`](https://github.com/loophp/collection/commit/1e8de4acb4e659dfb52cf00ebf2b6f18eb989b97)
- refactor: Minor types fixes. [`77db2cd`](https://github.com/loophp/collection/commit/77db2cddf5d1b7718b7f041305689034144b1699)

## [4.0.0](https://github.com/loophp/collection/compare/3.4.3...4.0.0) - 2021-03-18

### Merged

- update psalm type for map operation [`#72`](https://github.com/loophp/collection/pull/72)
- chore(deps): Bump actions/stale from v3.0.17 to v3.0.18 [`#70`](https://github.com/loophp/collection/pull/70)
- Fix typo in the docs [`#68`](https://github.com/loophp/collection/pull/68)
- Fix minimum PHP version in the docs [`#69`](https://github.com/loophp/collection/pull/69)
- feat: Add Dump operation. [`#67`](https://github.com/loophp/collection/pull/67)
- chore(deps): Bump actions/stale from v3.0.16 to v3.0.17 [`#66`](https://github.com/loophp/collection/pull/66)
- chore(deps): Bump actions/cache from v2 to v2.1.4 [`#64`](https://github.com/loophp/collection/pull/64)
- chore(deps): Bump actions/stale from v3.0.15 to v3.0.16 [`#65`](https://github.com/loophp/collection/pull/65)
- fix: Update behavior of Apply operation. [`#63`](https://github.com/loophp/collection/pull/63)
- chore(deps): Bump actions/stale from v3.0.14 to v3.0.15 [`#60`](https://github.com/loophp/collection/pull/60)
- chore(deps-dev): Update infection/infection requirement from ^0.20.1 to ^0.20.1 || ^0.21.0 [`#61`](https://github.com/loophp/collection/pull/61)

### Fixed

- update psalm type for map operation [`#71`](https://github.com/loophp/collection/issues/71)

### Commits

- **Breaking change:** fix: Update behavior of Apply operation. [`e4fa034`](https://github.com/loophp/collection/commit/e4fa03447be559f4c5a835d788e408c06a31ff62)
- **Breaking change:** refactor: Update Every operation. [`fb542be`](https://github.com/loophp/collection/commit/fb542bea984d222c57c742874ae0e960a2631ed6)
- **Breaking change:** refactor: Update TakeWhile operation. [`dbb9307`](https://github.com/loophp/collection/commit/dbb9307a118519ab2aaa1d941c4afbf58ffbba9b)
- **Breaking change:** refactor: Update Until operation. [`71a7693`](https://github.com/loophp/collection/commit/71a769368bfed5d92cb799024692b6a252eb10f3)
- docs: Update changelog for release 4.0.0. [`730a638`](https://github.com/loophp/collection/commit/730a63823b972332a7bb27b322424ab8db440264)
- refactor: Minor syntax update (php74). [`3c2d3e3`](https://github.com/loophp/collection/commit/3c2d3e31536ca095be5e50c7498968d7b237ea41)
- chore: Update badge. [`c5a9e58`](https://github.com/loophp/collection/commit/c5a9e58298de080f6ec1ed94e1620346ca4a9800)
- fix: Documentation code style. [`cd0f8f8`](https://github.com/loophp/collection/commit/cd0f8f818ed730df004bc5211e49b0e846167094)
- cs: Fix minor things here and there. [`9780bbd`](https://github.com/loophp/collection/commit/9780bbdfbc768b6cb2a8475a6754e0cdb4e06523)
- fix: Documentation code style. [`152447b`](https://github.com/loophp/collection/commit/152447b9d894f88a01fdb3878c1c9a4c0f6739f3)
- docs: Minor typing update. [`5aa1d02`](https://github.com/loophp/collection/commit/5aa1d0270be6afc0c5c18519b2e5e6c1346bf5da)
-  docs: Minor typing update. [`f620859`](https://github.com/loophp/collection/commit/f6208598e5f2e24c928a427cd8b42039a66d996c)
-  docs: Minor typing update. [`84ea356`](https://github.com/loophp/collection/commit/84ea356cb372351a9a7deb4673c4acb18792ace8)
- fix: Typo in README. [`be4aec3`](https://github.com/loophp/collection/commit/be4aec30db6d61320018bc1bae362d6e12af6d54)
- refactor: Update Merge operation - use PHP 7.4 code style. [`e967e01`](https://github.com/loophp/collection/commit/e967e014c2c0c5ccb6c18c3a29b40c15473baed4)
- refactor: Update Append operation - use PHP 7.4 code style. [`27285f8`](https://github.com/loophp/collection/commit/27285f8b695ec4fe5e2e8cd4cb543b3886e5dbc9)
- refactor: Update Prepend operation - use PHP 7.4 code style. [`b990edb`](https://github.com/loophp/collection/commit/b990edbd2d94ea3c5b731f75483388ef72d40bae)
- refactor: Update Drop operation - use PHP 7.4 code style. [`406afee`](https://github.com/loophp/collection/commit/406afee28725ebcd7c671b9d191010e3901725e6)
- feat: Add Partition command. [`97f8479`](https://github.com/loophp/collection/commit/97f847987bca1c2484288df9b2e0644ea1b6b88b)
- refactor: Remove obsolete PHPCS options. [`bc6d61e`](https://github.com/loophp/collection/commit/bc6d61e95f375f5cc7303870592dc98ab1563ab8)
- fix: Update Github configuration. [`9327044`](https://github.com/loophp/collection/commit/9327044665b04978c0708ae8a60f9f3f3fa135f2)
- refactor: Minor cosmetic stuff. [`42197be`](https://github.com/loophp/collection/commit/42197be7bf929b77311949cc6633363fc56c9123)
- refactor: Fix CS. [`bd8c40f`](https://github.com/loophp/collection/commit/bd8c40f8c3af745303fcfb69ea2b998bc9e9f234)
- docs: Update Apply documentation. [`51b2494`](https://github.com/loophp/collection/commit/51b2494d23eac2aa93d92deec8ebca3506d157f8)
- refactor: Cleanup. [`0d87d15`](https://github.com/loophp/collection/commit/0d87d15dd3b5e90c5ebae047e35b06287d24b4b3)
- docs: Update typing information. [`51eff67`](https://github.com/loophp/collection/commit/51eff672b25ff8a7767ca62924dfba5957fd1b0a)
- Update Apply. [`2797d5d`](https://github.com/loophp/collection/commit/2797d5dbf58250ca9fe3ff18e470b97564ce0748)
- Add tests. [`0567c27`](https://github.com/loophp/collection/commit/0567c27285e05fb2f9f89727b16d7c6b1f08b405)
- Fix CS. [`7705b94`](https://github.com/loophp/collection/commit/7705b949fe2f8e047f2442eb333de1deb8366212)
- chore(deps-dev): Update infection/infection requirement || ^0.21.0 [`e591835`](https://github.com/loophp/collection/commit/e591835bc0fbeeac0827ebaf717a8043a964a602)
- refactor: Minor optimization in Collection::fromCallable(). [`6d2e65a`](https://github.com/loophp/collection/commit/6d2e65af370e043be99f05f8b2db437cb99e4ee7)
- docs: Update typing information. [`0f2d096`](https://github.com/loophp/collection/commit/0f2d0961c43135684423e2321c6bb640557e7bab)
- refactor: Minor style and type changes. [`34d626c`](https://github.com/loophp/collection/commit/34d626ce0fc6de32692e6fc0ffa0d68d1c725df1)
- docs: Update typing information. [`6c14308`](https://github.com/loophp/collection/commit/6c143083c6d0fa5fd1324216a5c84956040b1748)
- docs: Update. [`79d8b2a`](https://github.com/loophp/collection/commit/79d8b2a9159362c3a5a61abc188494a245965583)
- docs: Update typing information. [`861cb9f`](https://github.com/loophp/collection/commit/861cb9f1f593eea41ebafb40a761eabf606a95d3)
- refactor: Update Split operation. [`7502dc0`](https://github.com/loophp/collection/commit/7502dc05725a34b562ecf47e04fedae18826b222)
- refactor: Update Has operation. [`88cae79`](https://github.com/loophp/collection/commit/88cae79815effff64fce34d3e1ae15f102843ce4)
- refactor: Update Contains operation. [`e646c8c`](https://github.com/loophp/collection/commit/e646c8cce4b844bcf27fbd99a9b957548fca072c)
- refactor: Update Distinct operation. [`102a45d`](https://github.com/loophp/collection/commit/102a45deaa3d2147cb6b88d33dcdf5c87284a038)
- refactor: Update DropWhile operation. [`0a91335`](https://github.com/loophp/collection/commit/0a91335c203deb80165ed1a295e6f34ad14c3474)
- refactor: Update MatchOne operation. [`d1bdbdf`](https://github.com/loophp/collection/commit/d1bdbdf8cc71769050c498bfb6d1c783e59cda24)
- refactor: Update Since operation. [`c8c3d9b`](https://github.com/loophp/collection/commit/c8c3d9ba5ae7bf2025f5c1a8c9e5b8ab4acf10a0)
- refactor: Update Distinct operation. [`80e676b`](https://github.com/loophp/collection/commit/80e676b5f9c3b648bc93982e60d7cec2d1ab7502)
- refactor: Minor - Fix typing information. [`c7aebfe`](https://github.com/loophp/collection/commit/c7aebfefa301b9e02600766646b122edff135f0e)
- refactor: Minor - add missing return types. [`837bd76`](https://github.com/loophp/collection/commit/837bd769ddc6ff4db15d3d89e72ed20827c28681)
- refactor: Minor optimization in Unwindow operation. [`710c52f`](https://github.com/loophp/collection/commit/710c52f9d1b8204c82db2a1253501b7a32ac7397)
- refactor: Minor optimization in Split operation. [`ae36094`](https://github.com/loophp/collection/commit/ae3609417f241e716274dba6d236c15b6eb48ea4)

## [3.4.3](https://github.com/loophp/collection/compare/3.4.2...3.4.3) - 2021-01-03

### Commits

- **Breaking change:** refactor: Update Since operation. [`0420906`](https://github.com/loophp/collection/commit/04209063779ec48e44d8d8b3e772c0b67446e052)
- docs: Update changelog. [`9be6443`](https://github.com/loophp/collection/commit/9be6443c532e447f26f3cdc38f9876bb0ce8c5ba)
- refactor: Update Split operation. [`5b9d153`](https://github.com/loophp/collection/commit/5b9d1535f6b16ec27c8b778ab5afad83bbf8a43d)

## [3.4.2](https://github.com/loophp/collection/compare/3.4.1...3.4.2) - 2021-01-03

### Commits

- docs: Update changelog. [`1e36e85`](https://github.com/loophp/collection/commit/1e36e85bbacd8218292c1f1f5ac2b1f25c21ed8e)
- refactor: Update and simplify typing information. [`6ab1622`](https://github.com/loophp/collection/commit/6ab1622ebf47189a23405539fe851ce95efcaa68)
- refactor: Optimize DropWhile operation. [`68d7bdc`](https://github.com/loophp/collection/commit/68d7bdca0c5e4c1ad0e841422c2a3d7c1e4f4934)
- refactor: Optimize Group operation. [`a4b2653`](https://github.com/loophp/collection/commit/a4b26534503eba2a970670d223383833fcd21b22)

## [3.4.1](https://github.com/loophp/collection/compare/3.4.0...3.4.1) - 2021-01-02

### Commits

- docs: Update changelog. [`d7cd376`](https://github.com/loophp/collection/commit/d7cd376d71d770d4196c98bbe1279ac73c13e328)
- refactor: Optimize DropWhile operation. [`d91eb93`](https://github.com/loophp/collection/commit/d91eb93c1a57cb59929891d82406b47f2989c92d)
- refactor: Optimize Group operation. [`aa418fe`](https://github.com/loophp/collection/commit/aa418fe9d03ddc5d8e2592589b09f38a89516ed4)
- refactor: Update Drop operation. [`3d4786b`](https://github.com/loophp/collection/commit/3d4786b609b31f616e2de8500a51eebb0b290a80)
- refactor: Minor documentation changes. [`7957e26`](https://github.com/loophp/collection/commit/7957e2682fe7af25b913099a744f4b572e0ce3c8)
- refactor: Update Zip operation. [`37593eb`](https://github.com/loophp/collection/commit/37593eb4ed14e2fbb84df341956c70e67ffb6caf)

## [3.4.0](https://github.com/loophp/collection/compare/3.3.5...3.4.0) - 2020-12-30

### Merged

- Use key and current operation at the same time [`#58`](https://github.com/loophp/collection/pull/58)

### Commits

- docs: Update changelog. [`45a46b8`](https://github.com/loophp/collection/commit/45a46b87beef427654060d433fa17ec9b059d378)
- refactor: Return instead of yield. [`a7b6a9c`](https://github.com/loophp/collection/commit/a7b6a9c8964cfdb26b080844bfd8c1eb0970dc89)
- tests: Update tests. [`9472d03`](https://github.com/loophp/collection/commit/9472d03836e08e03b03a35ea4ee0b589a822ac47)
- docs: Update typing information. [`09d0531`](https://github.com/loophp/collection/commit/09d0531da9476bc805f1e7cafefda0167a2fdfcb)
- docs: Update documentation. [`77debe9`](https://github.com/loophp/collection/commit/77debe9b773382d9301dc6030e1c487e01d9edef)
- tests: Update tests. [`d8a82a5`](https://github.com/loophp/collection/commit/d8a82a55ec83cd7eaa50d64cfa879cb137c39ed4)
- refactor: Simplify operations. [`e1d91ec`](https://github.com/loophp/collection/commit/e1d91ec45955777b0b2e25d26c8dadd6d03013d1)
- refactor: Use Foreach loops." [`c8d66c1`](https://github.com/loophp/collection/commit/c8d66c1f07008ec2fd593da25d069fb6de470c9f)
- fix: Simple fix which should fix the issue. [`804b4de`](https://github.com/loophp/collection/commit/804b4de9ec746f6753092a4380fdbddc2eb85cf4)
- tests: Reproduce issue in a test. [`f09ae23`](https://github.com/loophp/collection/commit/f09ae23cf977a418a037f6597c1be4aa48a5ef36)
- refactor: Factorize closures. [`739e9c6`](https://github.com/loophp/collection/commit/739e9c642ce6c796cc1c5c529d9b3df405e7b4ee)

## [3.3.5](https://github.com/loophp/collection/compare/3.3.4...3.3.5) - 2020-12-27

### Commits

- docs: Update changelog. [`4c4b77d`](https://github.com/loophp/collection/commit/4c4b77d16744f17e161d8fc89e15061d4d1a7d1f)
- refactor: Rename the Match class. [`74d3682`](https://github.com/loophp/collection/commit/74d3682ca201a10f329348d5d70464e9604eccd1)

## [3.3.4](https://github.com/loophp/collection/compare/3.3.3...3.3.4) - 2020-12-27

### Commits

- docs: Update changelog. [`6acbd55`](https://github.com/loophp/collection/commit/6acbd55d413e3f41939825fe1bc3525e73acef50)
- chore: Update .gitignore. [`ea4bd0c`](https://github.com/loophp/collection/commit/ea4bd0c0609cddc24c65a1f6e4f6ae0eadc5129f)
- docs: Update typing information. [`0f6431c`](https://github.com/loophp/collection/commit/0f6431cc6f06c47c1f4f02546f661ed4a262a393)
- refactor: Update Match operation. [`81c0922`](https://github.com/loophp/collection/commit/81c092205a3f4f8e1475c7f0bb86db44d7b5aa0f)

## [3.3.3](https://github.com/loophp/collection/compare/3.3.2...3.3.3) - 2020-12-26

### Commits

- docs: Update changelog. [`02116ab`](https://github.com/loophp/collection/commit/02116abe87e51bd177a239347405604f5ec84605)
- refactor: Use Match operation in other operations. [`f676c19`](https://github.com/loophp/collection/commit/f676c19fca2de8fb92e92e743929dd614f562b05)
- docs: Update typing information. [`0ae8995`](https://github.com/loophp/collection/commit/0ae89957f8e50af84650b83e30ffdd5758e954eb)
- feat: Add match operation. [`fa01f65`](https://github.com/loophp/collection/commit/fa01f653bd6d589e5c3a069c2faacbd69a787514)

## [3.3.2](https://github.com/loophp/collection/compare/3.3.1...3.3.2) - 2020-12-24

### Commits

- docs: Update changelog. [`b08ee64`](https://github.com/loophp/collection/commit/b08ee64dbb2af75697e74eb42555df26cc44f15e)
- refactor: Use For loop instead of Foreach. [`c59cea9`](https://github.com/loophp/collection/commit/c59cea9b56b8c8ef97c1a0cf87eb8863e3be5e82)

## [3.3.1](https://github.com/loophp/collection/compare/3.3.0...3.3.1) - 2020-12-21

### Merged

- chore(deps-dev): Update drupol/php-conventions requirement from ^2.0.3 to ^2.0.3 || ^3.0.0 [`#55`](https://github.com/loophp/collection/pull/55)

### Commits

- docs: Update changelog. [`f826fa4`](https://github.com/loophp/collection/commit/f826fa4f074c042dfc34aee9427b9d8fe0f7efca)
- refactor: Use For loop instead of Foreach. [`47e0f5e`](https://github.com/loophp/collection/commit/47e0f5e872297802fa0748b1381bf684b6d261ba)
- docs: Update typing information. [`a1d636f`](https://github.com/loophp/collection/commit/a1d636f5214cb50dceca10ba1ad9566e40b34018)
- refactor: Minor updates. [`17eac77`](https://github.com/loophp/collection/commit/17eac77c99d6f9be821a321f01d97a0910ab4e23)
- fix: Update Implode operation. [`eafa573`](https://github.com/loophp/collection/commit/eafa57396100c4c08cd056e101310ba967f48431)
- refactor: Introduce MultipleIterableIterator. [`aa7701d`](https://github.com/loophp/collection/commit/aa7701d5eecac343d1d2b22ecb8560a937f5d5f4)
- refactor: Use EmptyIterator. [`4390145`](https://github.com/loophp/collection/commit/4390145c21a002e424ac4b1cc07726ecc1d8a4fb)
- chore(deps-dev): Update drupol/php-conventions requirement || ^3.0.0 [`497e332`](https://github.com/loophp/collection/commit/497e33231f06e52d90b99fc4627fa8d7172985bc)
- refactor: Minor update in ArrayCacheIterator::valid(). [`1ed8a16`](https://github.com/loophp/collection/commit/1ed8a16f591f059da1853a99d6a14c728c8a13f4)

## [3.3.0](https://github.com/loophp/collection/compare/3.2.0...3.3.0) - 2020-12-17

### Merged

- Iterators refactoring [`#54`](https://github.com/loophp/collection/pull/54)
- chore(deps-dev): Update friends-of-phpspec/phpspec-code-coverage requirement from ^5 to ^5 || ^6 [`#53`](https://github.com/loophp/collection/pull/53)

### Commits

- docs: Update changelog. [`1e843a3`](https://github.com/loophp/collection/commit/1e843a3e76ef6a90f526930a81349c3e12a9a135)
- tests: Add more tests. [`8fc51fd`](https://github.com/loophp/collection/commit/8fc51fd0d1d49064abd21d7c90dc9e0e1ecc31c7)
- refactor: Mark iterators as internal. [`af7ee07`](https://github.com/loophp/collection/commit/af7ee070ba434d0106c13d9f769227d31708fab6)
- refactor: Rewrite iterators and optimize things here and there. [`87124da`](https://github.com/loophp/collection/commit/87124dabed11bd7be911c0afe543872880c2c3c2)
- chore(deps-dev): Update friends-of-phpspec/phpspec-code-coverage requirement || ^6 [`164a8b5`](https://github.com/loophp/collection/commit/164a8b5b03d5447303449f0a7fc34e107a711ae7)

## [3.2.0](https://github.com/loophp/collection/compare/3.1.1...3.2.0) - 2020-12-15

### Commits

- docs: Update changelog. [`a6e12ed`](https://github.com/loophp/collection/commit/a6e12ed9e498564b52beaabda195c64f416ec8fa)
- refactor: Update various operations. [`b5da182`](https://github.com/loophp/collection/commit/b5da182bc4801b8ede504f1ee6816924c09677de)
- refactor: Use more IteratorIterator. [`0127f40`](https://github.com/loophp/collection/commit/0127f40d3dc337d1fb022a12287c9565d4ae616a)
- refactor: Minor code style update. [`54d0f8e`](https://github.com/loophp/collection/commit/54d0f8e66208166dd10d073e4d766676242b3dc7)
- docs: Fix code example. [`65769b4`](https://github.com/loophp/collection/commit/65769b45fa2fa4d36a3f3adb76fe1f7e8e52518f)

## [3.1.1](https://github.com/loophp/collection/compare/3.1.0...3.1.1) - 2020-12-08

### Merged

- Update ScanLeft so it doesn't go further if the iterator is not valid. [`#49`](https://github.com/loophp/collection/pull/49)

### Commits

- docs: Update changelog. [`a4464cb`](https://github.com/loophp/collection/commit/a4464cb0b93822e41269d78cb7d58ae441ce586c)
- fix: Update ScanLeft so it doesn't go further if the iterator is not valid. [`5d9e448`](https://github.com/loophp/collection/commit/5d9e448dff2b792e872cca52543ab565bb195242)
- docs: Update documentation. [`e518492`](https://github.com/loophp/collection/commit/e518492b35ef219465bc6e0983b607f84d54308f)

## [3.1.0](https://github.com/loophp/collection/compare/3.0.5...3.1.0) - 2020-12-06

### Merged

- Add $seed parameter to RandomIterator [`#47`](https://github.com/loophp/collection/pull/47)
- chore(deps): Bump actions/stale from v3.0.13 to v3.0.14 [`#46`](https://github.com/loophp/collection/pull/46)
- chore(deps): Update actions/checkout requirement to v2.3.4 [`#45`](https://github.com/loophp/collection/pull/45)

### Commits

- docs: Update changelog. [`d06aebc`](https://github.com/loophp/collection/commit/d06aebc6eef1829f388e8e632d7f8238eeb232e1)
- refactor: Update CS. [`9852751`](https://github.com/loophp/collection/commit/9852751f9c2dd9ff271f1f908231c504de915293)
- refactor: Add a $seed parameter to RandomIterator. [`be7a0c1`](https://github.com/loophp/collection/commit/be7a0c160c201a4042d1a0920de10b6c53c47512)
- ci: Always run unit tests. [`bbf0045`](https://github.com/loophp/collection/commit/bbf0045c7d41e844f3cb11c35a0a2c41471507e6)
- docs: Update changelog. [`169e00e`](https://github.com/loophp/collection/commit/169e00e0234711df56e9c5ee0c1fef313971b075)

## [3.0.5](https://github.com/loophp/collection/compare/3.0.4...3.0.5) - 2020-11-23

### Merged

- ci: Split CI files. [`#44`](https://github.com/loophp/collection/pull/44)
- chore(deps-dev): Update phpspec/phpspec requirement from ^5.1.2 || ^6.2.1 to ^5.1.2 || ^6.2.1 || ^7.0.0 [`#43`](https://github.com/loophp/collection/pull/43)
- chore(deps): Bump actions/stale from v3.0.12 to v3.0.13 [`#38`](https://github.com/loophp/collection/pull/38)
- chore(deps): Bump actions/checkout from v2.3.3 to v2.3.4 [`#39`](https://github.com/loophp/collection/pull/39)
- chore(deps-dev): Update friends-of-phpspec/phpspec-code-coverage requirement from ^4.3.2 to ^4.3.2 || ^5.0.0 [`#42`](https://github.com/loophp/collection/pull/42)

### Commits

- docs: Update changelog. [`26d3551`](https://github.com/loophp/collection/commit/26d35513bada78ebc40f6ff141afe72b03a61dec)
- docs: Update README badge. [`7140fc7`](https://github.com/loophp/collection/commit/7140fc7c3cef74fe32f2f964672fff2fcb0ff24e)
- ci: Split Github Actions into multiple files. [`a442fea`](https://github.com/loophp/collection/commit/a442fea8bf7383809bdba9b6773e30fe037e2c3b)
- chore(deps-dev): Update friends-of-phpspec/phpspec-code-coverage requirement || ^5.0.0 [`cd52844`](https://github.com/loophp/collection/commit/cd52844c3cf94e083b28bf04d764bca243e86b12)
- docs: Update typing information. [`0ac6f71`](https://github.com/loophp/collection/commit/0ac6f71efec9a69c51ffa2286a1d75965e6bddef)

## [3.0.4](https://github.com/loophp/collection/compare/3.0.3...3.0.4) - 2020-11-12

### Commits

- docs: Update changelog. [`cd260e2`](https://github.com/loophp/collection/commit/cd260e268750258384540d5f9f15b1a15b21b7c1)
- chore: Update static configuration dev files. [`0d3b268`](https://github.com/loophp/collection/commit/0d3b268fb74d216e14dfea7a36f696bc234cc644)
- refactor: Improve performance by preventing the creation of multiple ClosureIterator at each operation call. [`dd01c4e`](https://github.com/loophp/collection/commit/dd01c4ea3a75fc93ed045bbf2f2f9c8065f3c18b)

## [3.0.3](https://github.com/loophp/collection/compare/3.0.2...3.0.3) - 2020-11-07

### Merged

- Fix `asyncMap` warning in the docs [`#41`](https://github.com/loophp/collection/pull/41)

### Commits

- docs: Update changelog. [`a8cafb5`](https://github.com/loophp/collection/commit/a8cafb582af26fe6868bb98f310529b6f1aee5dc)
- refactor: Update AsyncMap operation - major improvements - thanks @kelunik. [`1fbf5e9`](https://github.com/loophp/collection/commit/1fbf5e92bdc819e0e33eb0a430494daaa6d76bdf)
- Fix asyncMap warning in the docs [`5a1b7be`](https://github.com/loophp/collection/commit/5a1b7be924a538647d76ee98b297325c1438fd3b)

## [3.0.2](https://github.com/loophp/collection/compare/3.0.1...3.0.2) - 2020-11-06

### Commits

- docs: Update changelog. [`b97df67`](https://github.com/loophp/collection/commit/b97df675da79e8a494f8b635f14b64fcbc81f9ad)
- refactor: Update Head and First operations. [`eb792af`](https://github.com/loophp/collection/commit/eb792af45f1c45d639ee1d34525d5598e58f862e)
- refactor: Update asyncMap operation, make it variadic. [`8b848bb`](https://github.com/loophp/collection/commit/8b848bb515a10f49520f2ef175aae533347ed5a8)
- docs: Add missing link. [`113b4aa`](https://github.com/loophp/collection/commit/113b4aa1accd76f934a6aebc0cbaf6bf69f020a8)

## [3.0.1](https://github.com/loophp/collection/compare/3.0.0...3.0.1) - 2020-11-05

### Merged

- New asyncMap() operation (featuring amphp!) [`#40`](https://github.com/loophp/collection/pull/40)

### Commits

- docs: Update changelog. [`bd62ce6`](https://github.com/loophp/collection/commit/bd62ce6f236bc022d781b16d66d692b4311ce295)
- feat: Add asyncMap operation. [`6139ba6`](https://github.com/loophp/collection/commit/6139ba6223770d44176cea33024f11ac6cc6ea4a)
- chore: Add amphp/parallel dependency. [`3ca953b`](https://github.com/loophp/collection/commit/3ca953bdd3a10d3dc928f5acd853983badcffbf5)

## [3.0.0](https://github.com/loophp/collection/compare/2.7.4...3.0.0) - 2020-10-27

### Merged

- Refactoring - Preparation of release 3.0 [`#34`](https://github.com/loophp/collection/pull/34)

### Commits

- **Breaking change:** refactor: Update constructors. [`a080fae`](https://github.com/loophp/collection/commit/a080fae32f215f54f615963ea80b0d0406d43665)
- **Breaking change:** refactor: Remove Collection::with constructor. [`90c732c`](https://github.com/loophp/collection/commit/90c732c30db34c47c073f4613b2d349c4b68d266)
- docs: Update changelog. [`3f847a1`](https://github.com/loophp/collection/commit/3f847a14b1c2f56355bd3a1014308948be0a7e8f)
- tests: Update tests. [`7d81431`](https://github.com/loophp/collection/commit/7d81431e698f5078d1e509e9a4948d900672e307)
- refactor: Update composer.json. [`504567a`](https://github.com/loophp/collection/commit/504567aa430d18e5b6e8248332575f6370c52594)
- ci: Test on PHP 7.4 only. [`eed419c`](https://github.com/loophp/collection/commit/eed419c9b8f5f3be34d80624731c222c76ee2905)
- ci: Drop support of PHP 7.1. [`1aae097`](https://github.com/loophp/collection/commit/1aae097d2bd99cdf3e3df538e8954e0c96bcb974)
- refactor: Add forgotten typed argument. [`9fd2f9d`](https://github.com/loophp/collection/commit/9fd2f9d07d4a4fac6d6cfe1dd3fae19b52cdf2db)
- test: Update tests. [`693e7a6`](https://github.com/loophp/collection/commit/693e7a6ce77ebd0de14cb2be0785eabaecf4ace6)
- refactor: PHP 7.4 upgrade. [`ef8e8da`](https://github.com/loophp/collection/commit/ef8e8da78f751235b1b3470e60ab0c0315be77ce)
- docs: Update documentation. [`f84063d`](https://github.com/loophp/collection/commit/f84063dc7db5cb2fe812e5631d0265dc931c5550)
- refactor: Update CacheIterator [`02dc0a4`](https://github.com/loophp/collection/commit/02dc0a4875c5f31b2963e5b156f879253b06ae2f)
- docs: Update annotations. [`7386746`](https://github.com/loophp/collection/commit/73867463d9b4229ea5548c7da667781002741e46)
- refactor: Update Iterator annotations. [`dc9a311`](https://github.com/loophp/collection/commit/dc9a3119611cd9a84453a6e2ec14435713807f19)

## [2.7.4](https://github.com/loophp/collection/compare/2.7.3...2.7.4) - 2021-06-11

### Commits

- refactor: Deprecate Collection::with() static constructor. [`8060689`](https://github.com/loophp/collection/commit/8060689da7fc248b9ce5a95939536d5e8dd9059e)

## [2.7.3](https://github.com/loophp/collection/compare/2.7.2...2.7.3) - 2020-10-17

### Merged

- chore(deps-dev): Update vimeo/psalm requirement from 3.17.1 to 3.17.2 [`#35`](https://github.com/loophp/collection/pull/35)
- chore(deps): Bump actions/stale from v3.0.11 to v3.0.12 [`#30`](https://github.com/loophp/collection/pull/30)
- chore(deps-dev): Update vimeo/psalm requirement from 3.16 to 3.17.1 [`#32`](https://github.com/loophp/collection/pull/32)
- Fix simple code examples path [`#31`](https://github.com/loophp/collection/pull/31)

### Commits

- docs: Update changelog. [`b3b3c62`](https://github.com/loophp/collection/commit/b3b3c62f2200607b8075780d0694a3311dcb12dc)
- chore: Update composer.json. [`4a395bd`](https://github.com/loophp/collection/commit/4a395bd8efc1c0540e28324807059c8d9c0b5156)
- test: Add more tests. [`0529610`](https://github.com/loophp/collection/commit/052961065386659ad47926983626376729fdbe2b)
- fix: Fix RandomIterator::rewind(). [`c3c1dd0`](https://github.com/loophp/collection/commit/c3c1dd08b00449a26ad7a43c93ba5b7687bda25f)
- ci: Enable GD extension. [`07b0868`](https://github.com/loophp/collection/commit/07b086817de380061c7828e734d57e4eca557362)
- refactor: Update times constructor. [`053cb80`](https://github.com/loophp/collection/commit/053cb80e036f5037dc72aec567de1aa0aaea2fcf)
- refactor: Simplify static constructors. [`958dc79`](https://github.com/loophp/collection/commit/958dc79048de4e15dba70463841ecd080b262ede)
- docs: Move code examples into simple files. [`464ff15`](https://github.com/loophp/collection/commit/464ff1504b193dc94aaf9e31e2cf3f257d853012)

## [2.7.2](https://github.com/loophp/collection/compare/2.7.1...2.7.2) - 2020-10-10

### Commits

- docs: Update changelog. [`1b07b0d`](https://github.com/loophp/collection/commit/1b07b0dd970370cdf8e4bf57424544d50dc60eb9)
- docs: Update documentation. [`94773e6`](https://github.com/loophp/collection/commit/94773e68c080e8a52f1038e29751753c3a849652)
- refactor: Add missing annotations. [`bdedb51`](https://github.com/loophp/collection/commit/bdedb51f91547117ff1069dffdc2686bba18b5f0)
- refactor: Add return statement. [`1a57ffb`](https://github.com/loophp/collection/commit/1a57ffb6a9589a7da0811ae7d24955252c7635df)
- test: Add missing tests. [`a2217a8`](https://github.com/loophp/collection/commit/a2217a8dba01e72354bec7738a98e76dcc22d7d6)
- refactor: Align TakeWhile and Until operations. [`b680be9`](https://github.com/loophp/collection/commit/b680be963a113a554efe293c771cc74b52912065)
- refactor: Leverage tacit programming. [`aa4df6e`](https://github.com/loophp/collection/commit/aa4df6e545216d72e5cf8ae3c8739bdc12000da3)

## [2.7.1](https://github.com/loophp/collection/compare/2.7.0...2.7.1) - 2020-10-08

### Merged

- Fix Has operation. [`#29`](https://github.com/loophp/collection/pull/29)
- chore(deps): Bump actions/checkout from v2.3.2 to v2.3.3 [`#27`](https://github.com/loophp/collection/pull/27)

### Commits

- docs: Update changelog. [`7ea007d`](https://github.com/loophp/collection/commit/7ea007d7b74b6d5e936bcc1a2b12ed8cd75a37c0)
- fix: Fix Has operation. [`8af7817`](https://github.com/loophp/collection/commit/8af7817cef291570f83169a4753861d150f17ae2)
- refactor: Leverage tacit programming. [`69541f6`](https://github.com/loophp/collection/commit/69541f6179d48cf2c5da5d201a3cd600b86d8dde)

## [2.7.0](https://github.com/loophp/collection/compare/2.6.3...2.7.0) - 2020-10-07

### Commits

- **Breaking change:** refactor: Remove Reduce operation. [`42934a9`](https://github.com/loophp/collection/commit/42934a920ccd661d068f3915bbb1cdf134254d9b)
- **Breaking change:** refactor: Update Implode operation. [`4cedd34`](https://github.com/loophp/collection/commit/4cedd346fbfe5970ad81285e84decf480fa4acf1)
- **Breaking change:** refactor: Update Has operation. [`082384b`](https://github.com/loophp/collection/commit/082384bef0af271c4a4bef5f55fc4a1825b6c66b)
- **Breaking change:** refactor: Update Get operation. [`b761ce7`](https://github.com/loophp/collection/commit/b761ce744257ddd626635ecb4835cf86769c9199)
- **Breaking change:** refactor: Update Contains operation. [`a99e72a`](https://github.com/loophp/collection/commit/a99e72a72b6c89069fee560bfb3292a29c3b8046)
- **Breaking change:** refactor: Update Falsy, Nullsy and Truthy operations. [`07fbce4`](https://github.com/loophp/collection/commit/07fbce4f560528bcbfa81112fd5e19049273a527)
- **Breaking change:** refactor: Update Fold* operations. [`f6828f0`](https://github.com/loophp/collection/commit/f6828f0fc1d1792f84cfda9e9a299c1d38702f42)
- **Breaking change:** refactor: Rename Run into Pipe. [`e3b3261`](https://github.com/loophp/collection/commit/e3b32615f338a94664a25756d77ffe094cb27d4a)
- docs: Update changelog. [`bca5780`](https://github.com/loophp/collection/commit/bca578096280182d7565580204c23274407ec419)
- docs: Update README. [`ce14a0d`](https://github.com/loophp/collection/commit/ce14a0d71698bf7264a36011903f6ab0bb907279)
- feat: Add Group operation. [`a7df56c`](https://github.com/loophp/collection/commit/a7df56c8e8c503aa8ffbfe24425e4479e9d1de00)
- refactor: Rename Group operation into GroupBy [`248e5a4`](https://github.com/loophp/collection/commit/248e5a4e2d6f7882801d95128bf36748a0f9019c)

## [2.6.3](https://github.com/loophp/collection/compare/2.6.2...2.6.3) - 2020-10-07

### Commits

- docs: Update changelog. [`46911c7`](https://github.com/loophp/collection/commit/46911c776b193dbcecf82cb6eb505f7b8863012f)
- refactor: Update return types. [`25cc915`](https://github.com/loophp/collection/commit/25cc91573551cf23d815dfa8702a743090f6acc3)
- refactor: Add missing annotations. [`f1aae0d`](https://github.com/loophp/collection/commit/f1aae0d72398d6ebc18d4167a27dda8ce94498eb)
- feat: Add Inits operation. [`70855c3`](https://github.com/loophp/collection/commit/70855c36c67d102e1e57e4eb7f02623a139bb51b)
- docs: Update annotations. [`39ad38f`](https://github.com/loophp/collection/commit/39ad38f0a5e05d2a447b03e1a3e86bf7a820be08)
- feat: Add Span operation. [`48d9620`](https://github.com/loophp/collection/commit/48d9620ad4ddf29f2f4d697bd659019452abb21d)

## [2.6.2](https://github.com/loophp/collection/compare/2.6.1...2.6.2) - 2020-10-02

### Commits

- docs: Update changelog. [`ea9a8f1`](https://github.com/loophp/collection/commit/ea9a8f1eec3768670e2468d116d41ae3686582e6)
- feat: Add Tails operation. [`1299853`](https://github.com/loophp/collection/commit/12998539035b32bb616787f9716a963316d6d081)
- chore: Update .gitignore. [`ffae108`](https://github.com/loophp/collection/commit/ffae108e4cf56d51d8d4c88415ffcb90b6bb0041)
- chore: Update composer.json. [`2686f05`](https://github.com/loophp/collection/commit/2686f05bc783da814f4d839e912200e79659a0db)
- docs: Update annotations. [`0e111ab`](https://github.com/loophp/collection/commit/0e111ab757bd4629a5c338bbe7ddff01bce0427c)
- refactor: Update Distinct operation. [`9d2579c`](https://github.com/loophp/collection/commit/9d2579cee6c4dec02b063316a4474743efc360e0)
- docs: Update API page. [`7dfe75f`](https://github.com/loophp/collection/commit/7dfe75fc1d8271e8578509e616dfb5eef200e2a1)
- docs: Add link. [`824ed65`](https://github.com/loophp/collection/commit/824ed6538de9dcbdd0679f7a99352a1a16b26766)
- refactor: Init operation improvements. [`7d23688`](https://github.com/loophp/collection/commit/7d236882e53d9c4b17d58b96705acfc6045cbc4f)
- refactor: Last operation improvements. [`88350e2`](https://github.com/loophp/collection/commit/88350e2f07b77b2595b0331fa39cf8d341199fdf)
- refactor: Leverage tacit programming (point free style) [`13b5d6d`](https://github.com/loophp/collection/commit/13b5d6d55751c33bdb8e2ed838d214ff0f8d42b5)
- docs: Add missing link. [`675af9a`](https://github.com/loophp/collection/commit/675af9aeee401bdd5f54555f4d7dc3fdf3423eae)

## [2.6.1](https://github.com/loophp/collection/compare/2.6.0...2.6.1) - 2020-09-23

### Commits

- docs: Update changelog. [`a8a3eec`](https://github.com/loophp/collection/commit/a8a3eec2b3a2af9de0787a1331b44824e670d2b5)
- refactor: Leverage tacit programming (point free style) [`764a3c6`](https://github.com/loophp/collection/commit/764a3c6ba5b2b0bb3ef77b22a4a07b31dac5a87a)
- chore: Update Grumphp configuration. [`855aa63`](https://github.com/loophp/collection/commit/855aa634371842fa86dda1620525d27570ac5ce4)
- feat: Add Every operation. [`8ea76af`](https://github.com/loophp/collection/commit/8ea76af40d7e25a49605e99db3e9f56c68b05bb3)

## [2.6.0](https://github.com/loophp/collection/compare/2.5.5...2.6.0) - 2020-09-22

### Commits

- **Breaking change:** refactor: Update Compact operation. [`10fd55f`](https://github.com/loophp/collection/commit/10fd55f1f958e083f60f86ac51e34bdcaf4084ce)
- **Breaking change:** refactor: Update Explode operation. [`d28abcd`](https://github.com/loophp/collection/commit/d28abcd17590f24baab68f9ab7fb1f3e33aa00b5)
- **Breaking change:** refactor: Update Split operation. [`1c669b2`](https://github.com/loophp/collection/commit/1c669b2b21145069395192b7b530a0bbea4420bd)
- docs: Update changelog. [`47b4716`](https://github.com/loophp/collection/commit/47b471672381dadde584bc3bbc31d131b0c83f37)
- feat: Add fromFile static constructor. [`7211052`](https://github.com/loophp/collection/commit/7211052435cf8d1498f0bf2b6b374011e6b550d5)
- feat: Add Words operation. [`72df47a`](https://github.com/loophp/collection/commit/72df47a4f72da849bf74c211536e2f3e4ed913b6)
- feat: Add Unwords operation. [`b6aef32`](https://github.com/loophp/collection/commit/b6aef3235936260aa112cf4cba3bb191aff6928c)
- feat: Add Unlines operation. [`ab9fde2`](https://github.com/loophp/collection/commit/ab9fde20d262ef0232d4114449fd478f05c8061d)
- feat: Add Lines operation. [`24cd4a5`](https://github.com/loophp/collection/commit/24cd4a5a763895ab78d62221836b0c5b6e620eb0)
- refactor: Refactor operations using their parent operation counterpart. [`0835f2d`](https://github.com/loophp/collection/commit/0835f2d83c04ed49bafbd18f8f8fcddb219ef5eb)
- refactor: Update Reverse operation. [`6ce7b13`](https://github.com/loophp/collection/commit/6ce7b13e674f3c4105a360850a8c6bb541760579)
- feat: Add scanLeft1 operation. [`8b9aaa3`](https://github.com/loophp/collection/commit/8b9aaa3114766e3e83d2996823b31d89c7b27c20)
- feat: Add scanRight1 operation. [`1183407`](https://github.com/loophp/collection/commit/118340712e3412950acb3b30afaf796533be3bf2)
- feat: Add scanRight operation. [`c01274f`](https://github.com/loophp/collection/commit/c01274f953ebce4f7665a0ac2b767f2bb42e2a59)
- docs: Update FoldLeft and FoldRight. [`98ced08`](https://github.com/loophp/collection/commit/98ced08469e7f019d80010900fdb5c650fabb261)
- feat: Add scanLeft operation. [`ff0c7e4`](https://github.com/loophp/collection/commit/ff0c7e429950b18ab3040a7519578110b96a50c9)
- docs: Update annotations. [`317483e`](https://github.com/loophp/collection/commit/317483e966c6005e9c306d7534492c440bb2008e)
- feat: Add FoldRight1 operation. [`18b9b1d`](https://github.com/loophp/collection/commit/18b9b1d00cb7fa7d60d48c18b4e8e9051d68aa0c)
- feat: Add FoldLeft1 operation. [`c034101`](https://github.com/loophp/collection/commit/c0341016cd93348cde87f0f91b4fde40355b64db)
- docs: Update README. [`ecdbc18`](https://github.com/loophp/collection/commit/ecdbc185ff631a3e2c17645fb3fdf90b98ea0a68)
- docs: Update documentation. [`7985455`](https://github.com/loophp/collection/commit/79854557747c1807403c26909c8ece0225b55500)
- docs: Update API page. [`516f786`](https://github.com/loophp/collection/commit/516f786bad6985fc01da1d447002c033810f47ea)

## [2.5.5](https://github.com/loophp/collection/compare/2.5.4...2.5.5) - 2020-09-16

### Merged

- Update vimeo/psalm requirement from 3.14.2 to 3.16 [`#26`](https://github.com/loophp/collection/pull/26)
- Bump actions/create-release from v1.1.3 to v1.1.4 [`#25`](https://github.com/loophp/collection/pull/25)

### Commits

- chore: Update composer.json. [`92f9ed8`](https://github.com/loophp/collection/commit/92f9ed849e4d066b2a1e3104d5de3123d60b217b)
- docs: Update changelog. [`091c97c`](https://github.com/loophp/collection/commit/091c97ccafdd3e7a44df7ca99ffad9aae68bfe6e)
- feat: Add Unwindow operation. [`e240e6a`](https://github.com/loophp/collection/commit/e240e6a83e4d80879c971b4c6238b59bb97ff81d)

## [2.5.4](https://github.com/loophp/collection/compare/2.5.3...2.5.4) - 2020-09-14

### Commits

- docs: Update changelog. [`249f0f3`](https://github.com/loophp/collection/commit/249f0f3d889a55dfb9178c78bbcf766ce7704e7b)
- ci: Update release process to include changelog automatically. [`abb4e4f`](https://github.com/loophp/collection/commit/abb4e4f5e59e63966270b5be4b269a0b88ccebd3)
- Bump actions/stale from v3.0.10 to v3.0.11 [`f7ba528`](https://github.com/loophp/collection/commit/f7ba528f986dc47fa6432544ff905b793458ccfc)
- docs: Update Usage page. [`2d5d9f6`](https://github.com/loophp/collection/commit/2d5d9f6ea8d0703e7a1b5682ef7a448ce85c5040)
- docs: Update documentation of Append and Prepend operations. [`8441ad6`](https://github.com/loophp/collection/commit/8441ad6aa770e641539fa44667ae7e0860dea70c)
- feat: Add Duplicate operation. [`b2d2a82`](https://github.com/loophp/collection/commit/b2d2a825214e555ec52ce2586dbf41f3d8021b21)
- docs: Updated append method documentation. [`da6caa9`](https://github.com/loophp/collection/commit/da6caa91bf3f2d32bd2a7a1e605aaf6200cdd686)

## [2.5.3](https://github.com/loophp/collection/compare/2.5.2...2.5.3) - 2020-09-12

### Commits

- **Breaking change:** refactor: Update Associate operation. [`168eb1a`](https://github.com/loophp/collection/commit/168eb1a02b0c295f693c11381069f278e5b08f13)
- docs: Update changelog. [`b3bd1fe`](https://github.com/loophp/collection/commit/b3bd1fe63680a77dfcbd0c1a138f4abb7fd474b6)
- docs: Update annotations. [`6cb1e77`](https://github.com/loophp/collection/commit/6cb1e770b48c72fe23453f1d6e137d4ebd2107a8)
- refactor: Update some operation to make them lazy by default. [`ff6c556`](https://github.com/loophp/collection/commit/ff6c556a6f042019141110ab0543137f9af546c3)
- docs: Update documentation. [`d990886`](https://github.com/loophp/collection/commit/d9908863c3697c9d5b7684496affa455e95228fd)
- refactor: Update Product operation. [`1318e41`](https://github.com/loophp/collection/commit/1318e41c8b88e5e248c45f0d20ed48f592f842e1)

## [2.5.2](https://github.com/loophp/collection/compare/2.5.1...2.5.2) - 2020-09-08

### Commits

- Update changelog. [`3340899`](https://github.com/loophp/collection/commit/3340899eda7e1308b6414e03bea965198133629f)
- Fix Psalm version. [`f1cd23a`](https://github.com/loophp/collection/commit/f1cd23aa349fd290750868f3e889a7b0e6794156)

## [2.5.1](https://github.com/loophp/collection/compare/2.5.0...2.5.1) - 2020-09-08

### Commits

- Update changelog. [`de2ebda`](https://github.com/loophp/collection/commit/de2ebda40e7115cbc493b147a51da4799e51c427)
- Update annotations. [`3830e38`](https://github.com/loophp/collection/commit/3830e38e8323c56a423e506d429ee9df5312fe38)
- Fix Random operation. [`47b2f55`](https://github.com/loophp/collection/commit/47b2f55ce8ffdbe7b677c67f468889cd275c6e32)

## [2.5.0](https://github.com/loophp/collection/compare/2.4.0...2.5.0) - 2020-09-08

### Commits

- Update changelog. [`3ec344d`](https://github.com/loophp/collection/commit/3ec344de4e9ff0dca20342b8c0879ff9138fbe5e)
- Remove unneeded variable assignations. [`8ae26f6`](https://github.com/loophp/collection/commit/8ae26f6aa15a52afc3c99ec89d13c0b1170bc0de)
- Update Unpack operation. [`c253472`](https://github.com/loophp/collection/commit/c253472835f0bd86d2d9f8cf93b804d8dc313ea6)
- Replace Only with IntersectKeys operation. [`78a20a3`](https://github.com/loophp/collection/commit/78a20a3e77bf27ec37b4ef1d69f7c4dea49559fc)
- Use Filter operation when it's possible. [`841a7c5`](https://github.com/loophp/collection/commit/841a7c50f3c6c0dbbd1ab2dca5c830cfec2e8c45)
- Update annotations. [`3dbf949`](https://github.com/loophp/collection/commit/3dbf949b6884bf33b7b898f5eedfe58ed3b214d2)
- Replace Iterate with Unfold operation. [`6401f74`](https://github.com/loophp/collection/commit/6401f747cc772815a50cff523c40637aaa1fcb22)
- Update Limit operation. [`95f8856`](https://github.com/loophp/collection/commit/95f8856f02622ce182abf905d08ab33755c97321)
- Update Window operation. [`c78813b`](https://github.com/loophp/collection/commit/c78813b4c7629675ba8e0ceb11e420428e3572dd)

## [2.4.0](https://github.com/loophp/collection/compare/2.3.5...2.4.0) - 2020-09-07

### Commits

- Update changelog. [`5a392f3`](https://github.com/loophp/collection/commit/5a392f3da927640ed00a80eb1584e6a0e0220a5c)
- Add Unzip operation. [`cad956f`](https://github.com/loophp/collection/commit/cad956fd1bc34ea04b01f1804165178fc8b82123)
- Add TakeWhile operation. [`c9e6701`](https://github.com/loophp/collection/commit/c9e6701463709c112d1ee3dab8fc76d54c62dcd0)
- Rename Skip into Drop. [`0c6b01a`](https://github.com/loophp/collection/commit/0c6b01ae505c00baebe9cfc53c11ec698c3a39d4)
- Add DropWhile operation. [`cf816a3`](https://github.com/loophp/collection/commit/cf816a3d6c861520accfe7cec443229b3e2c8148)
- Update FoldLeft operation. [`deb825d`](https://github.com/loophp/collection/commit/deb825d3b3b0dd1233ff3c5d8481f10a01d03b9c)
- Update Last operation. [`4ae3d35`](https://github.com/loophp/collection/commit/4ae3d3593f3f88f9f35da06ca31b589b5d8092a2)
- Update First operation. [`79a1f5c`](https://github.com/loophp/collection/commit/79a1f5cd6b5ebc14e403df9c82a395a0896a044c)
- Update Reduction operation. [`f20942c`](https://github.com/loophp/collection/commit/f20942c5055e111c201acb7d3fd6103336fb0cb6)
- Add Current operation. [`ed246ed`](https://github.com/loophp/collection/commit/ed246edadd6eedd8e6a347af3552119f2b7fbff4)
- Add Key operation. [`24fa777`](https://github.com/loophp/collection/commit/24fa7772b94abc786459491e899eb482e97dd7fb)
- Update PHPCS comments. [`ce83560`](https://github.com/loophp/collection/commit/ce835608c14587a2519c672f89199e9eec519cf0)
- Refactor reducer callbacks. [`9d1e176`](https://github.com/loophp/collection/commit/9d1e17606b6422ff8518a53b187105d831140da4)
- Update annotations. [`1bb45f2`](https://github.com/loophp/collection/commit/1bb45f28ee9ba522545d45e4bf75db5fc4cdb899)
- Update Associate operation. [`1b9ca3c`](https://github.com/loophp/collection/commit/1b9ca3cd4c19ee873420986a847268c9541a43be)

## [2.3.5](https://github.com/loophp/collection/compare/2.3.4...2.3.5) - 2020-09-03

### Commits

- Update changelog. [`485c0fa`](https://github.com/loophp/collection/commit/485c0fa776b07fa25b6a10ada99b90584926b93b)
- Update Map operation. [`1521b23`](https://github.com/loophp/collection/commit/1521b23313f74e234f7a5dd09e7b816fc30b3eb4)

## [2.3.4](https://github.com/loophp/collection/compare/2.3.3...2.3.4) - 2020-09-03

### Commits

- Update changelog. [`296aea1`](https://github.com/loophp/collection/commit/296aea1de64998a9e112b3da5ce90453ebda954c)
- Fix Map operation. [`25314c8`](https://github.com/loophp/collection/commit/25314c8c43fd70f3cea1598dbea73d5da0c10ed7)
- Refactor reducer callbacks. [`8f83368`](https://github.com/loophp/collection/commit/8f83368d1997b6ae280a72dcac86d2b1f2e87c0f)
- Add RandomIterator Iterator. [`ce64bca`](https://github.com/loophp/collection/commit/ce64bcaf2185fc7af6fa45fa7772e232de788c60)
- Update Only operation. [`f74152b`](https://github.com/loophp/collection/commit/f74152b7158c62743673cac4f47dac81b77fa9c6)
- Update Forget operation. [`67811b3`](https://github.com/loophp/collection/commit/67811b3857d08287da78c29b165c7536bded4d08)
- Update annotations. [`aa7edf9`](https://github.com/loophp/collection/commit/aa7edf9c89c5cb0d829047f6eb76161229c2f6f0)
- Add Init operation. [`192e7ad`](https://github.com/loophp/collection/commit/192e7ad452e14633b65354a6aae98dbe90baacce)

## [2.3.3](https://github.com/loophp/collection/compare/2.3.2...2.3.3) - 2020-09-01

### Commits

- Update changelog. [`ea07a8d`](https://github.com/loophp/collection/commit/ea07a8d4eb0ca5e34a388bb237864ea59346e1d5)
- Replace the Loop operation with the Cycle operation. [`2189649`](https://github.com/loophp/collection/commit/21896492b80a27fca2bb433e92c92f3f30271378)
- Add Unfold operation. [`58eeaa0`](https://github.com/loophp/collection/commit/58eeaa0c8924393e9e285126ed17a89f85303225)
- Update annotations. [`af3226f`](https://github.com/loophp/collection/commit/af3226f8c88826fc6f0a18f92248c5b244b6045f)
- Update documentation. [`3bb8caa`](https://github.com/loophp/collection/commit/3bb8caa8139d834eb0407280a7951d054ce1a0bf)

## [2.3.2](https://github.com/loophp/collection/compare/2.3.1...2.3.2) - 2020-08-31

### Commits

- Update Changelog. [`94c010a`](https://github.com/loophp/collection/commit/94c010a46882914b1e45f8621fb77e7b73f53a74)
- Update annotations. [`5cf2513`](https://github.com/loophp/collection/commit/5cf251342cc07de1d5f06da9fb91b9904e233ae5)
- Update Skip operation. [`8f668d7`](https://github.com/loophp/collection/commit/8f668d73ef623b6db0ef711dfb6e05dda32b6264)

## [2.3.1](https://github.com/loophp/collection/compare/2.3.0...2.3.1) - 2020-08-30

### Commits

- Update Changelog. [`2e7d5e6`](https://github.com/loophp/collection/commit/2e7d5e66b1adec5f63a1234007cfb56a233d1c5a)
- Update annotations. [`37c6a5c`](https://github.com/loophp/collection/commit/37c6a5c3f1b6e6c39dd1b323dd3c49848f4f0415)
- Add forgotten interface links. [`be3f405`](https://github.com/loophp/collection/commit/be3f40582acd1b84427e9b1625621e23d00a7fb3)

## [2.3.0](https://github.com/loophp/collection/compare/2.2.0...2.3.0) - 2020-08-30

### Merged

- Convert operations and transformations to function objects [`#18`](https://github.com/loophp/collection/pull/18)

### Commits

- Update Changelog. [`cddf0b8`](https://github.com/loophp/collection/commit/cddf0b898cfbd20451fe9c44f3858dc53b7fbead)
- Remove duplicated information. [`961f5b6`](https://github.com/loophp/collection/commit/961f5b646ea70bf8c426dce5a357cffba22ed2ef)
- Update README.md. [`cb84521`](https://github.com/loophp/collection/commit/cb84521d2f160b92eb8352ae55bfe823c574f315)
- Update documentation. [`f115d1d`](https://github.com/loophp/collection/commit/f115d1ddf5b6cfc34dfd9cb219f993327cf64579)
- Update Psalm annotations. [`126994f`](https://github.com/loophp/collection/commit/126994fc17640eb23235a76d568c01b80911c26d)
- Update tests. [`a7c1ff3`](https://github.com/loophp/collection/commit/a7c1ff3f015119e64a7bff650a1c9292520ba69b)
- Convert Transformations into Operations. [`e36b03c`](https://github.com/loophp/collection/commit/e36b03c66a412ef4c5a2601c56543c4b7e5017b5)
- Syntactic sugar to reduce the amount of parenthesis. [`f40dc3b`](https://github.com/loophp/collection/commit/f40dc3b56628f165028c3047c4a635206d740efd)
- Convert Operations and Transformations into function object. [`6ce8ecf`](https://github.com/loophp/collection/commit/6ce8ecfd386d7697ebe5ea230fd09e53b1dacb49)

## [2.2.0](https://github.com/loophp/collection/compare/2.1.0...2.2.0) - 2020-08-28

### Fixed

- Update Group operation. (Fix #19) [`#19`](https://github.com/loophp/collection/issues/19)

### Commits

- Update Changelog.md. [`7daf209`](https://github.com/loophp/collection/commit/7daf209a58fd2c7997e8039e615a8d3878328e7d)
- Add Changelog.md. [`6869e40`](https://github.com/loophp/collection/commit/6869e402b665e1f205a82068a692b4552c0033a8)
- Update documentation. [`efccd88`](https://github.com/loophp/collection/commit/efccd8828ad762c6606fa7ba9f3408b95134cedb)
- Update Iterate constructor. [`01155c2`](https://github.com/loophp/collection/commit/01155c2452f80b018cf5a78c293016eca5b3b23b)
- Add IfThenElse operation. [`f9c0c04`](https://github.com/loophp/collection/commit/f9c0c04d5bca222fad6999c1abc53ff33275dc14)
- Update Flatten operation. [`f5ceeb8`](https://github.com/loophp/collection/commit/f5ceeb87c6372c9d0e518565351f6266fe595d3f)
- Update Group operation. [`6fce398`](https://github.com/loophp/collection/commit/6fce398180eef65af6ecf7c80581c3ded8eff5cb)
- Update tests. [`18a7885`](https://github.com/loophp/collection/commit/18a788581be3c80a268f1b73d8bdb3738feaeafe)
- Update Runable interface [`07c1c12`](https://github.com/loophp/collection/commit/07c1c1285875213c38589918f9fb0107c3929b44)
- Update Chunk operation [`1260974`](https://github.com/loophp/collection/commit/12609745fefe39aed895912f70b119a2c8ecb786)
- Remove obsolete annotations [`8e25055`](https://github.com/loophp/collection/commit/8e25055abb4a52f42248cf15ade7e554d688bc85)
- Update Column operation [`b071823`](https://github.com/loophp/collection/commit/b0718237624b3a5009107a92f952e81e2f2369b8)
- Update Filter operation [`5f4d134`](https://github.com/loophp/collection/commit/5f4d1343c7ad5b70b33dcb0eaac16d1dd1decfe1)
- Update Cache operation [`afbcac3`](https://github.com/loophp/collection/commit/afbcac3ced17202559c35037dab552ad3de9ec3e)
- Update Cycle operation [`a5388d2`](https://github.com/loophp/collection/commit/a5388d25542c4808a5e82650b1217fb26f52cfa9)
- Update Slice operation [`fc5baa6`](https://github.com/loophp/collection/commit/fc5baa67673a85c176497dd4f3cb9c7ebe8c1482)
- Update Split operation. [`6c3b94f`](https://github.com/loophp/collection/commit/6c3b94f9818c0bd4abfa17ebb455b7b513202818)
- Add missing tests. [`7e15694`](https://github.com/loophp/collection/commit/7e156944dc71e66bff3d91a20c1b641cf9614e0b)
- Update Limit operation. [`4578422`](https://github.com/loophp/collection/commit/45784228d903df3cb52bb8bd7f281c2911085aba)
- Update Psalm/typing annotations. [`d5207e3`](https://github.com/loophp/collection/commit/d5207e3e4f2dc27773053cff1285f482fe1bbbf8)
- Update Scale operation. [`85db341`](https://github.com/loophp/collection/commit/85db341c73940dfab28da2538bdc3940ffd1c573)
- Update Map operation. [`1702597`](https://github.com/loophp/collection/commit/1702597065648df7006c87a06becf5bf5e4827d2)
- Update operations to use Pack instead of Wrap. [`810bff8`](https://github.com/loophp/collection/commit/810bff8585636d24023d33eca7cd4ac3989dffa2)
- Add Unpack operation. [`54a3e97`](https://github.com/loophp/collection/commit/54a3e97bb727755d3cb4d8ca081079aaa973badd)
- Add Pack operation. [`412734c`](https://github.com/loophp/collection/commit/412734c9f0a82e9be8b4a782da082913c313cc0d)
- Update Unpair operation. [`2d7ce6e`](https://github.com/loophp/collection/commit/2d7ce6e05e08d38e087004a62626ca512f1669f0)

## [2.1.0](https://github.com/loophp/collection/compare/2.0.5...2.1.0) - 2020-08-22

### Merged

- Bump actions/create-release from v1.1.2 to v1.1.3 [`#16`](https://github.com/loophp/collection/pull/16)
- Bump actions/stale from v3.0.9 to v3.0.10 [`#15`](https://github.com/loophp/collection/pull/15)

### Commits

- Update composer.json. [`def5f26`](https://github.com/loophp/collection/commit/def5f2612340adf461e75da2e7437ccc3153934c)
- Update Tail operation. [`1d15657`](https://github.com/loophp/collection/commit/1d156571c57ee92d0f3e6b41d3e8847580585965)
- Update Filter operation. [`5a7e41d`](https://github.com/loophp/collection/commit/5a7e41d873a89b56868b2af09820bf4c3d3500a6)
- Update First operation. [`c7ac8b3`](https://github.com/loophp/collection/commit/c7ac8b3759e8bd239fe5ed597a9eedeb6e453b1c)
- Update Last operation. [`a8cb98f`](https://github.com/loophp/collection/commit/a8cb98f2db08dc49ce0d292d3d32d64b9a358041)
- Add Head operation. [`126bf8a`](https://github.com/loophp/collection/commit/126bf8afd5e8e6778c834adf602db05ed46fcaa7)
- Update README. [`a05ec2f`](https://github.com/loophp/collection/commit/a05ec2f9a6ee9a5c0ce91829f9c2661e90c48605)
- Update Map operation. [`8b1dd27`](https://github.com/loophp/collection/commit/8b1dd2721841f14106603f1cfc2055f4a0a2dc75)
- Update Last transformation. [`6496559`](https://github.com/loophp/collection/commit/6496559efd89d461903de6b0c3c2ce74c85a3058)
- Update Filter operation. [`f81494a`](https://github.com/loophp/collection/commit/f81494a3e38d9455fa6a1dff4493a0cc2179c4aa)
- Delete obsolete Walk operation in favor of Map operation. [`a8dac33`](https://github.com/loophp/collection/commit/a8dac3378e4563673cfabe5a753c6bc4a50bab44)
- Update Split operation. [`84e6381`](https://github.com/loophp/collection/commit/84e63813ba8a0fdecb2b07275b892aee695cce0e)
- Add new example. [`d1be59e`](https://github.com/loophp/collection/commit/d1be59ef01651a7c7794175fe5b2d88e3e58e353)
- Update typing information. [`e716b85`](https://github.com/loophp/collection/commit/e716b854527e576d3e9f76455d0f5f8dfe20bf17)
- Update typing information. [`81b7a6f`](https://github.com/loophp/collection/commit/81b7a6f546848812b74a12309d7e701cbe7536e7)
- Add missing return statements. [`119cdfe`](https://github.com/loophp/collection/commit/119cdfeb092b31970eac5a98f56e52d4f4ee8e69)
- Update Implode transformation. [`1c9e929`](https://github.com/loophp/collection/commit/1c9e929919e9482bec517aa746559d63071c79f2)
- Update FoldLeft/FoldRight transformations. [`cece391`](https://github.com/loophp/collection/commit/cece391c57ab7800246fc5ebd788f0ec4c738322)
- Update Last operation. [`ddde5cc`](https://github.com/loophp/collection/commit/ddde5cc6f1dd14ac079b68c58bb2dd3f68aac8ee)

## [2.0.5](https://github.com/loophp/collection/compare/2.0.4...2.0.5) - 2020-08-12

### Merged

- Bump actions/checkout from v2.3.1 to v2.3.2 [`#10`](https://github.com/loophp/collection/pull/10)

### Commits

- Various minor changes and optimizations. [`6e09157`](https://github.com/loophp/collection/commit/6e091571fe8a6db581ff531c691f664c9aaf5e64)
- Update Contains transformation, make it variadic. [`b78a704`](https://github.com/loophp/collection/commit/b78a704f6c8dcecaee20284ef4441d17099e3103)

## [2.0.4](https://github.com/loophp/collection/compare/2.0.3...2.0.4) - 2020-08-08

### Commits

- Simplify the use of the Sort callback in userland. [`5014004`](https://github.com/loophp/collection/commit/5014004752b30a57c8e8cb95bdc4b4288e84c64f)

## [2.0.3](https://github.com/loophp/collection/compare/2.0.2...2.0.3) - 2020-08-07

### Commits

- Add new Github workflows, from ergebnis/php-library-template. [`c61749c`](https://github.com/loophp/collection/commit/c61749cac58d329a2b69a27206b456bcc8ea5c5c)
- Use parameters of Closure Iterator. [`9f5367b`](https://github.com/loophp/collection/commit/9f5367b9203fe3ed50b774e16360021088c8f5de)
- Update documentation. [`940fcec`](https://github.com/loophp/collection/commit/940fcec1d86d7296d7c87017755e0f6b09a67802)
- Add docker stack for building documentation locally. [`54d2559`](https://github.com/loophp/collection/commit/54d2559e2af97a33c7600ab2e8e0bae76ea7a64a)

## [2.0.2](https://github.com/loophp/collection/compare/2.0.1...2.0.2) - 2020-08-05

### Commits

- Add example with random number distribution. [`f49c1ca`](https://github.com/loophp/collection/commit/f49c1ca82870f7f79ae030cd60001528640a4dcb)
- Update Sort operation and remove the SortableIterableIterator. [`d0c7f2f`](https://github.com/loophp/collection/commit/d0c7f2fbe196573a9c467e9caddded2997c7eeba)
- Add more Psalm annotations. [`e7e7898`](https://github.com/loophp/collection/commit/e7e789819fb7987c0c5d723fd82664f30a78d740)
- Update README. [`aed338c`](https://github.com/loophp/collection/commit/aed338c8032e1cf4f6d0aeb989b174cb91a8c806)
- Remove obsolete Psalm annotation. [`a218d84`](https://github.com/loophp/collection/commit/a218d849ce91012ef73c39e2ee46e4e3a202744c)
- Add Associate operation. [`f76a0a5`](https://github.com/loophp/collection/commit/f76a0a52058ce08cffc1e198d8362b164618c387)
- Update and fix Psalm phpdoc. [`91c8900`](https://github.com/loophp/collection/commit/91c8900aee2f853d351b1caec55735688b2b0e03)

## [2.0.1](https://github.com/loophp/collection/compare/2.0.0...2.0.1) - 2020-08-04

### Commits

- Add Unpair operation. [`a94f3ee`](https://github.com/loophp/collection/commit/a94f3ee5910ada4888deb98707c5b04d30ad6d96)
- Add Pair operation. [`cd373c5`](https://github.com/loophp/collection/commit/cd373c5277fdfcd27dc99b1915ca1c837d2bdd8c)
- Use a CacheIterator iterator. [`1dcd9eb`](https://github.com/loophp/collection/commit/1dcd9eb698388cc21d11cc80f848bc30dba27310)

## [2.0.0](https://github.com/loophp/collection/compare/1.1.1...2.0.0) - 2020-08-03

### Merged

- Feat improve static analysis score. [`#8`](https://github.com/loophp/collection/pull/8)

### Commits

- Update README. [`69e9683`](https://github.com/loophp/collection/commit/69e9683e271474d2da5e46c89b440bebe2f803cc)
- Update Grumphp configuration file. [`5c5c0d1`](https://github.com/loophp/collection/commit/5c5c0d1c7a7f7f5722460286b068eb9c46721705)
- Update composer.json. [`ca6e895`](https://github.com/loophp/collection/commit/ca6e8958547eb9bcd3f23505429b38b100781aa9)
- Rewrite @template into @psalm-template. [`f488268`](https://github.com/loophp/collection/commit/f4882687d22c65a9eb1a6fad60ce26f967818dc3)
- Remove PHPStan config file. [`b3a39a3`](https://github.com/loophp/collection/commit/b3a39a306c6bc71c579557d3732b58c8556a7350)
- Update PHPDoc. [`e095c55`](https://github.com/loophp/collection/commit/e095c551a432b794b31b43ec40447103fda132a5)
- Update Intersperse operation. [`825b7da`](https://github.com/loophp/collection/commit/825b7daf235349aae3fbc89c2d9bb8a75ee0286b)
- Update Flip operation. [`0e1489a`](https://github.com/loophp/collection/commit/0e1489a16469b16f827764246bcb9d7fec7c95ac)
- Use an Iterator for Transformations. [`e5b6acd`](https://github.com/loophp/collection/commit/e5b6acdc9c437615c764e7733a2aff15f07c11c2)
- Remove obsolete Base class. [`1bab2c7`](https://github.com/loophp/collection/commit/1bab2c735f05f7b85cbe06c8f3ca292555552f1e)
- Improve static analysis phpdoc. [`f87758e`](https://github.com/loophp/collection/commit/f87758e6629cdbc4338b224f1c634bbcfd55ef48)
- Improve static analysis phpdoc. [`32bb7bf`](https://github.com/loophp/collection/commit/32bb7bf516ca436d533b2031ba4cfecd658979d1)
- Update default PSalm configuration and composer.json. [`cd12c3b`](https://github.com/loophp/collection/commit/cd12c3bd6a557ac7190fdc559dfefbafc3442539)
- Update default PSalm configuration. [`09e1f63`](https://github.com/loophp/collection/commit/09e1f637bcabc32454fe7c249e73b07e6d64c2f4)
- Disable PHPStan checks until bugs are fixed. [`a716ced`](https://github.com/loophp/collection/commit/a716cedc70f41f547ebf361659daefa71d919d26)
- Fix static analysis leftovers. [`8e3d262`](https://github.com/loophp/collection/commit/8e3d262b007d8258a64b8d5cb66524a78c5b2e46)
- Update typing. [`e1e25cf`](https://github.com/loophp/collection/commit/e1e25cfde371a69e6739f539ffe7371530562fcb)
- Update Contains operation. [`4723545`](https://github.com/loophp/collection/commit/4723545fc68bd73c7253290b68cc6fcda2357213)
- Add PHPStan configuration file to ignore unsupported features. [`2fda169`](https://github.com/loophp/collection/commit/2fda1690feb72b0eb1984b19dc7e9815ea2e9ef7)
- Add Has Transformation. [`5c69049`](https://github.com/loophp/collection/commit/5c69049151bc00dfa270ce340e6f988ae59c96e1)
- Update README. [`7699f1b`](https://github.com/loophp/collection/commit/7699f1b744051b925d62d396544cbbb003ee8c5c)
- Add tests for Random operation. [`c71549c`](https://github.com/loophp/collection/commit/c71549c069bc6efb95c5c7b56c95d53dd8fa44a9)
- Enable CI for PHP 7.1. [`8b94f6d`](https://github.com/loophp/collection/commit/8b94f6ddc493a4ae98abfa26945d6ea3b0ff7ad3)
- Prevent builds from failing on Windows. [`e65ddb8`](https://github.com/loophp/collection/commit/e65ddb86399e9a699e62807a93379fdf27863e50)
- Add documentation. [`95298d6`](https://github.com/loophp/collection/commit/95298d6cfbbca6b7c3c36488f7d81fb230c14271)
- Add documentation. [`7c5ee8f`](https://github.com/loophp/collection/commit/7c5ee8fad691f18f68865c022a4d31d24d39a5e4)
- New Random operation [`e20bd8e`](https://github.com/loophp/collection/commit/e20bd8ec8e86b954bc87f8dbcd42ff040beccaaf)
- Use an Iterator instead of iterable. [`377b214`](https://github.com/loophp/collection/commit/377b214191a16f29d0c15cb91e5400bd11c137e1)
- Update filter operation. [`8374728`](https://github.com/loophp/collection/commit/8374728d13af78bc86b1d6b3959bf14a0042fdfe)
- New Cache operation. [`63762eb`](https://github.com/loophp/collection/commit/63762eb3b47666999c4e80bcdceb29ab9cc538b2)
- Update Run operation. [`5a5a1bd`](https://github.com/loophp/collection/commit/5a5a1bd5c408b9a334054e7512dba9ee8ad20389)
- Update Map operation. [`106fbfe`](https://github.com/loophp/collection/commit/106fbfea5b5475356a8aa766ff0a6d3b09cb4e8b)
- New Intersect and IntersectKeys operation. [`3bc2006`](https://github.com/loophp/collection/commit/3bc2006ebd60bc05b40f079e8b66f0caac01486d)
- New Diff and DiffKeys operation. [`1cac685`](https://github.com/loophp/collection/commit/1cac685fcf1623dc12e41039f63d80215d39ce5d)
- Bump drupol/php-conventions. [`b65cffe`](https://github.com/loophp/collection/commit/b65cffe9c0d987a5b6539a11382fe650420eecfc)
- Update scrutinizer. [`2a41c7d`](https://github.com/loophp/collection/commit/2a41c7d5dcce1b5a50cd3ad728da29c433bc582f)
- Update Grumphp configuration file. [`7d5282d`](https://github.com/loophp/collection/commit/7d5282dfd5d6eece796f2d2b5b8780253fabb0ca)
- Update composer.json. [`29de649`](https://github.com/loophp/collection/commit/29de64955854eb81f960052f48a1f80fbce80fd9)

## [1.1.1](https://github.com/loophp/collection/compare/1.1.0...1.1.1) - 2020-07-20

### Merged

- Bump actions/checkout from v1 to v2.3.1 [`#7`](https://github.com/loophp/collection/pull/7)
- Fix installation instructions [`#6`](https://github.com/loophp/collection/pull/6)

### Commits

- Bump drupol/php-conventions. [`87d8762`](https://github.com/loophp/collection/commit/87d8762ddf9c05280df1632bf00904329aafdd02)
- Update Github action. [`a715506`](https://github.com/loophp/collection/commit/a715506e75c31738476b3a32c7a736efe81ca3e2)
- Simplify Since and Until operations. [`ced44cc`](https://github.com/loophp/collection/commit/ced44cce5211c95e036f7b78106c9a090d26f31d)
- Update documentation. [`51c5402`](https://github.com/loophp/collection/commit/51c5402ceea48279aae74e5b014b53ebf2412891)
- Update Collection::compact() and let user provide parameters. [`7733252`](https://github.com/loophp/collection/commit/7733252206ced0c85d344528d0e60887269d0056)
- Implements Collection::compact() operation. [`9970d38`](https://github.com/loophp/collection/commit/9970d38e177b22291c0c578b10737ba591b09aa7)
- Implements \JsonSerializable. [`8930335`](https://github.com/loophp/collection/commit/8930335fba7483f7f20db6ca5a5c5d97edef3d33)

## [1.1.0](https://github.com/loophp/collection/compare/1.0.11...1.1.0) - 2020-07-07

### Merged

- Bump actions/cache from v1 to v2 [`#4`](https://github.com/loophp/collection/pull/4)

### Commits

- Update documentation. [`67a0007`](https://github.com/loophp/collection/commit/67a0007eed0a242a35d237afc1b79583042ec478)
- Update Sort operation. [`98b2495`](https://github.com/loophp/collection/commit/98b2495e66ebf7ef9801df7066956eada951fd69)
- Update Slice operation. [`be98389`](https://github.com/loophp/collection/commit/be98389055622184bbc1c3873e9f4cb9a1046174)
- Update Shuffle operation. [`e88562a`](https://github.com/loophp/collection/commit/e88562a5d99df77984cb9279323d78b8c07ad86b)
- Update Scale operation. [`74b621c`](https://github.com/loophp/collection/commit/74b621c4e2f5654412bb27bd337dae2e0df570ee)
- Update RSample operation. [`980ebc5`](https://github.com/loophp/collection/commit/980ebc5ad3cce31d3aa0daa56196949cfe987d32)
- Update Product operation. [`5247ce5`](https://github.com/loophp/collection/commit/5247ce5593a5f0cfcea0f75a0da3607616f46b18)
- Update Chunk operation. [`84c629c`](https://github.com/loophp/collection/commit/84c629c979ecb9b6b11f76413aa997a3b7f068e1)
- Update Collapse operation. [`795aa06`](https://github.com/loophp/collection/commit/795aa0613f3b290b97afe4a0d6b5a685f6a2e25e)
- Update Permutate operation. [`72202db`](https://github.com/loophp/collection/commit/72202db6c649b5d4c0151d88913a039cac9a7634)
- Update Combination operation. [`64a64a4`](https://github.com/loophp/collection/commit/64a64a4e92d9ab597613ca1a2cf8885f19387769)
- Remove inheritdoc. [`5a727ae`](https://github.com/loophp/collection/commit/5a727aeab38d4ddf50507065d800147f0b096b81)
- Update composer.json. [`975e732`](https://github.com/loophp/collection/commit/975e73223b1af3957305dc45ba7fb3188bcc9831)
- Update Shuffle operation. [`74232f7`](https://github.com/loophp/collection/commit/74232f781adaa81919ec08b39e905768398632f7)
- Update Reverse operation. [`a9b6c9a`](https://github.com/loophp/collection/commit/a9b6c9ab5343968ebaa99ef1802bc0de6c590ca2)
- Update tests, use new factories. [`baa9caf`](https://github.com/loophp/collection/commit/baa9cafecaa5b951a781215434aee9491e9d27b4)
- Update Window operation. [`fe0d79b`](https://github.com/loophp/collection/commit/fe0d79b8ec890212a256fb1b8041e8d8b48e03f1)
- Update Times operation. [`3721100`](https://github.com/loophp/collection/commit/3721100483aded085a26dd9d34f3fa33bcb0a863)
- Update Tail operation. [`fe32346`](https://github.com/loophp/collection/commit/fe323469fe22c3dbd12efca57ffd19d691f5940d)
- Update Cycle operation. [`d91a49a`](https://github.com/loophp/collection/commit/d91a49a305b771ef6f5f4cf63dcb63fc6b5f3834)
- Update Chunk operation. [`20e3573`](https://github.com/loophp/collection/commit/20e3573e81e4267ae0e1dac95cbe9c52b012fdb0)
- Update Loop operation, use keys. [`597122c`](https://github.com/loophp/collection/commit/597122c1e660e36a58781f7596be3fda5ee7f615)
- Add new typed factories. [`615189f`](https://github.com/loophp/collection/commit/615189fa38512b5a64652cc92b2c50a966d2f74d)
- Add Wrap and Unwrap operations. [`0bd0e42`](https://github.com/loophp/collection/commit/0bd0e4261b6eb7995ab36a1ecde084fca495ae17)
- Update Append, Merge and Prepend operation. [`9b77e0e`](https://github.com/loophp/collection/commit/9b77e0eecafce48a66dd313ce18f7b18c61d75e5)
- Update documentation. [`02dd5be`](https://github.com/loophp/collection/commit/02dd5be1f484a72171b781a2739bf8b7df96c95f)
- Update FUNDING.yml file. [`44c566f`](https://github.com/loophp/collection/commit/44c566f81de9a4af21b99ed45371de3f7073fe0f)
- Update tests to avoid issues on CI. [`e0d5e27`](https://github.com/loophp/collection/commit/e0d5e27e351e09ce3aed19eb76827b6b3f63708d)
- Update PHPDoc, fix CS. [`0100651`](https://github.com/loophp/collection/commit/0100651512e06d11e6a4018bf24e42c6dacb6492)
- Update PHPDoc, remove obsolete doc. [`4589576`](https://github.com/loophp/collection/commit/4589576ba8a55745e91409321bc0cf9390a66da6)
- Update README and composer.json file. [`2531f66`](https://github.com/loophp/collection/commit/2531f669ab9feb28a9db10f9d4841bc171321669)
- Update README and documentation. [`e68c325`](https://github.com/loophp/collection/commit/e68c325e83b73ff32e9e5923860cda00db2fe42e)
- Add Group operation. [`93e7be8`](https://github.com/loophp/collection/commit/93e7be88b8c536452f474253864b80df7fe28127)
- Code style fixes. [`3253196`](https://github.com/loophp/collection/commit/3253196318e0194424b82bcb0864678061f35ff7)
- Add nunomadudo/phpinsights report. [`03400a7`](https://github.com/loophp/collection/commit/03400a790525ab5047116404d915e8f702806b0c)
- Add nunomadudo/phpinsights report. [`2ffb151`](https://github.com/loophp/collection/commit/2ffb151588f969dc6f40737b4c84054174c71625)
- Update Zip operation example. [`742d74f`](https://github.com/loophp/collection/commit/742d74f7291395ff72a352b329ec3a8bb40ae8e9)
- Update documentation. [`8c0b06d`](https://github.com/loophp/collection/commit/8c0b06d5843d8a02970d899e971258870f2dfd72)
- Minor update in Reduction operation. [`68578dd`](https://github.com/loophp/collection/commit/68578dda8eaf3051e73cd8733167689482f6bd75)
- Update Since operation. [`c3b420c`](https://github.com/loophp/collection/commit/c3b420c7a1d936a7022c629e279baa7bb0e2b516)
- Increase Grumphp timeout. [`4da37bc`](https://github.com/loophp/collection/commit/4da37bce4c62008545585c3afe02878073ef88af)
- Add Since operation. [`12a6bb6`](https://github.com/loophp/collection/commit/12a6bb61e51aa3c0f1e2d49ecff3d8ec1ff6860c)
- Update documentation. [`92f8c20`](https://github.com/loophp/collection/commit/92f8c2084de0fa1ffaa748587dd88f579d83cd7f)
- Get rid of all PSalm warnings. [`4498857`](https://github.com/loophp/collection/commit/4498857e7666357f48d8b0500f71887e00b947ce)
- Update badges. [`15891b8`](https://github.com/loophp/collection/commit/15891b8af4f55178b3b1499ea06905293dd62b22)
- Minor update to Frequency operation. [`5b2a3a7`](https://github.com/loophp/collection/commit/5b2a3a70c2c6f3fef0b474c080fbac8e39152b22)
- Add Frequency operation. [`039c803`](https://github.com/loophp/collection/commit/039c80321decc8c2d61d402f258c837190edafa4)
- Add a new example. [`df73058`](https://github.com/loophp/collection/commit/df730581d71e42cdff0e7b45a2ed0db1492ec9f1)
- Update README file. [`1a70029`](https://github.com/loophp/collection/commit/1a700293f1eecc8a43f0edee7b23cae25f3c95f7)
- Minor else statements removal. [`df0e2c9`](https://github.com/loophp/collection/commit/df0e2c99a4a609506837e01cb3611a18bb78cb3a)
- Minor optimization. [`80f722d`](https://github.com/loophp/collection/commit/80f722d240af08c8ed19060dd608beecf6a904b9)
- Remove duplicate type. [`de7d49c`](https://github.com/loophp/collection/commit/de7d49cb4c784144624cee43fe3c5cf1653eb8c6)
- Fix PHPStan. [`6e981db`](https://github.com/loophp/collection/commit/6e981dbf14ccad0e28348fee321af64e87b54001)
- Refactor the operations. [`df85420`](https://github.com/loophp/collection/commit/df85420abd0e1198a23411a81581778d9310eb3f)
- Minor optimization. [`cdd94a3`](https://github.com/loophp/collection/commit/cdd94a3e26a636ce8fc148bf45d86d8ca30c4066)
- Update PHPDoc. [`bacbadd`](https://github.com/loophp/collection/commit/bacbadd71c7bb738d2c355d1f5c0d707a0cdc972)
- Remove PHP 8 from CI. [`d632670`](https://github.com/loophp/collection/commit/d632670eb2e062b7fad5ce71a27385d71393e7fc)
- Add Falsy/Truthy/Nullsy transformations. [`e4bf275`](https://github.com/loophp/collection/commit/e4bf275960f8ceddb06e04b0a0bdce9db21594e7)
- Update composer.json. [`22d2ae9`](https://github.com/loophp/collection/commit/22d2ae93455b5dc5b34cd3180ea468b517288f84)
- Add Dependabot configuration. [`7431348`](https://github.com/loophp/collection/commit/7431348e3084b378736f794bbe2464ecbd36589d)
- Fix PHPStan issues. [`d36339a`](https://github.com/loophp/collection/commit/d36339aa23ad2f644cb196d8013a9d8aa91e8a98)
- Bump PHPStan. [`af643c5`](https://github.com/loophp/collection/commit/af643c51ec8fe0ff98c9df79b7997840541f6d5a)
- Fix PHPStan version until its bugs are fixed. [`c9aa01b`](https://github.com/loophp/collection/commit/c9aa01bf5563b64694ce41f61fa092f076a97930)
- Reduce PSALM warnings. [`7ffef09`](https://github.com/loophp/collection/commit/7ffef09de3b6d39aa078b7d0d618d6d135d1c9f7)
- Minor improvement. [`affab6c`](https://github.com/loophp/collection/commit/affab6c19bf8bf54c3d0b3217ed33a58cd545301)
- Add Transpose operation. [`0070b45`](https://github.com/loophp/collection/commit/0070b45086c81dae6daaa788ce3d39783fb08459)
- Optimize Zip operation. [`f87d6fc`](https://github.com/loophp/collection/commit/f87d6fc6f1b923fbaed87d127651da858d97fa31)
- Add Column operation. [`9cc7798`](https://github.com/loophp/collection/commit/9cc7798cf3c7e9893c51c40dfdd1b8c0862ce219)
- Fix some PSalm warnings. [`ca0b0b7`](https://github.com/loophp/collection/commit/ca0b0b77c05e954ea7f7d7ca3f0b3b525bf15aa8)
- Minor optimizations. [`07f058f`](https://github.com/loophp/collection/commit/07f058f3440fccb2522579b6c276a7e287189622)
- Minor optimizations. [`b21631a`](https://github.com/loophp/collection/commit/b21631aaf0d928b41ded80717465734f0ef8a778)
- Update Chunk operation. Now accept variadic parameter. [`c31335f`](https://github.com/loophp/collection/commit/c31335f3631f6814c1e52dda49e4b0f53ea31f85)
- Update PHPDoc. [`70fb09d`](https://github.com/loophp/collection/commit/70fb09d01a95ea390cc5e74e6fd5c37b5bf5f545)
- Enable PSaslm and its badge. [`402e2de`](https://github.com/loophp/collection/commit/402e2de58bfc976fc02ac37b462be811e51b3e74)
- Bump infection/infection. [`acf8dd1`](https://github.com/loophp/collection/commit/acf8dd1c06c920a4ce176413584b9cc541f700f4)
- Add PHP 8 in Github action configuration. [`5159694`](https://github.com/loophp/collection/commit/515969491e337434905076c78bf3a386932e4446)
- Refactoring. Pass the $collection object by default to the static function returned by the Operation object. Rename Operation::on() in Operation::__invoke(). [`c1b3f91`](https://github.com/loophp/collection/commit/c1b3f919efe9a0c7c21df3f970851899191f3451)
- Update GrumPHP configuration. [`17af0b2`](https://github.com/loophp/collection/commit/17af0b2e1b68e3906bb75b010a6d21dea7e0a133)
- Update documentation. [`9606092`](https://github.com/loophp/collection/commit/960609223a81a61b9a8aad2f2afb91eae280ea4b)
- Update composer.json. [`1f12eb9`](https://github.com/loophp/collection/commit/1f12eb98afe8c2ce8b0aacbdb5970f8be3770442)
- Update Github actions configuration. [`b25c0cf`](https://github.com/loophp/collection/commit/b25c0cfe881b833941e8c4da1468333066aecd21)
- Add Shuffle operation. [`35c58cb`](https://github.com/loophp/collection/commit/35c58cb0a2f8b148a7eeee24f070a24961da2378)
- Minor optimization. [`5c1f248`](https://github.com/loophp/collection/commit/5c1f2485c8c51a65cbc9886fb167800ed62ca14c)
- Update documentation. [`7b71cbc`](https://github.com/loophp/collection/commit/7b71cbc134a9f1dbf59ed285898479f18ded6eea)
- Add Window operation. [`95a87ca`](https://github.com/loophp/collection/commit/95a87ca4f6d650b6b16c83cc4a89fd522f92836c)
- Add Loop operation. [`4b7d288`](https://github.com/loophp/collection/commit/4b7d28896aa458338f20ea0a1e1e467df2497a76)
- Minor optimization in Slice operation. [`db761a6`](https://github.com/loophp/collection/commit/db761a69d47bb1ff9fa76b05e895a5e7f9c3a593)
- Leverage the variadic arguments wherever we can. [`978323e`](https://github.com/loophp/collection/commit/978323e3e9dc024f5d035348b8929638ff77d068)
- Use FoldLeft in "Last" transformation. [`ff1f702`](https://github.com/loophp/collection/commit/ff1f702b73a03ddf5877d9caabeb82056eb18705)
- Minor optimizations. [`18d20d7`](https://github.com/loophp/collection/commit/18d20d731cb7523b9f4da4540a8c9fec669817ed)
- Move files in their proper directory. [`dfb52f3`](https://github.com/loophp/collection/commit/dfb52f33ab09b283b0966a4545a26e75e343ec27)
- Bump drupol/php-conventions. [`66d47f2`](https://github.com/loophp/collection/commit/66d47f22d0334fec81871bfa2601be89194c92c0)
- Update Reduction operation. [`57cedbc`](https://github.com/loophp/collection/commit/57cedbc6c7cb212533bba91f02115780a9727268)
- Update Cycle operation. [`550819b`](https://github.com/loophp/collection/commit/550819bd76493706e8f56ec7aec0f4f39c2a2396)
- Update Walk operation. [`be33b49`](https://github.com/loophp/collection/commit/be33b493cc7af267ea0ea624dabb06ddeaf59f60)
- Update Times operation. [`7376353`](https://github.com/loophp/collection/commit/737635386daeeb30136585af1843fefedad3504b)
- Update Split operation. [`a323774`](https://github.com/loophp/collection/commit/a3237744269ec5a30d67f8b890c5fbb4d9a30d81)
- Add FoldLeft and FoldRight transformations. [`b261a89`](https://github.com/loophp/collection/commit/b261a891cf99d5d5b49c953b926d42a449b83bde)
- Fix PHPStan bogus issue by ignoring it. [`88fd00f`](https://github.com/loophp/collection/commit/88fd00f3fd43bdc173a4f16c43c2118cf54f10c5)
- Update Github actions configuration. [`a0352ae`](https://github.com/loophp/collection/commit/a0352ae07956f9c0190f009689a65184b4969c39)
- Update composer.json. [`82faa39`](https://github.com/loophp/collection/commit/82faa397c9b00800cd623a3630bf99fee4fe076d)
- Let the collection use a resource of type stream in its constructor. [`a780687`](https://github.com/loophp/collection/commit/a780687e68ce5d5789dc8f7b1411f54db985a386)
- Fix code style and PHPStan warnings. [`caf5a37`](https://github.com/loophp/collection/commit/caf5a37fe35b92669a6c552d0d2c3542fadb5a2b)
- Update documentation. [`bbbb99c`](https://github.com/loophp/collection/commit/bbbb99cbb327e5da69fb32f3b22c4fc5520b8c81)
- Update documentation. [`94691b8`](https://github.com/loophp/collection/commit/94691b8b7d99e7ad90c2cb87e192ee67e772ea94)
- Minor code style update. [`633b10a`](https://github.com/loophp/collection/commit/633b10ad98334cfdf2dd450822ac1a3f942a78fe)
- Update documentation. [`fc62742`](https://github.com/loophp/collection/commit/fc627421dbb5398c914c381a85c329750c7dd45c)
- Update documentation. [`68cd85b`](https://github.com/loophp/collection/commit/68cd85bc7995d1cbfa02efbd928774f2e38c4278)
- Update documentation. [`dbddf8f`](https://github.com/loophp/collection/commit/dbddf8fca566cd3dcb4b4e26b57697ab6b39745f)
- Update documentation. [`d397233`](https://github.com/loophp/collection/commit/d39723302074ef10f61695d3d08640fce86ca5e4)
- Improve code consistency based on documentation and interfaces. [`2c02bf3`](https://github.com/loophp/collection/commit/2c02bf3cad6be73ca875d0b7474321e4456a1e91)
- Add documentation. [`6f45767`](https://github.com/loophp/collection/commit/6f457672296505bed46eaa97c85c1215133b2d44)

## [1.0.11](https://github.com/loophp/collection/compare/1.0.10...1.0.11) - 2020-01-09

### Commits

- Let the callback return arrays with non numerical keys. [`77d111f`](https://github.com/loophp/collection/commit/77d111f43a35eb08486536b69f91452c6d40e21e)
- Now ::until() uses a variadic argument. [`34b62c4`](https://github.com/loophp/collection/commit/34b62c44e8402207b637942698141c66b9c3fcb3)
- Revert "Try to test using low deps." [`b325505`](https://github.com/loophp/collection/commit/b32550520c4e0c9f8536c111f7d81a0621bd6251)
- Try to test using low deps. [`f46348e`](https://github.com/loophp/collection/commit/f46348e8c139d3e699c09b1c60d4c8dedcb1c919)
- Minor changes to the ClosureIterator. [`ed2d0a9`](https://github.com/loophp/collection/commit/ed2d0a9fbafbce9153d5299a5ad24bdbe153d9c9)

## [1.0.10](https://github.com/loophp/collection/compare/1.0.9...1.0.10) - 2020-01-08

### Commits

- Fix the behavior of the ::apply() operation. [`719eea8`](https://github.com/loophp/collection/commit/719eea8f1df65df8a9467072089c2da2d998681b)
- Remove obsolete ::rebase() operation. [`486b835`](https://github.com/loophp/collection/commit/486b8352c1a0bf7a536f64e93f0553503dc0e3a5)
- Fix the behavior of the ::apply() operation. [`eb1c4ae`](https://github.com/loophp/collection/commit/eb1c4ae8dd66a7c4ca26414b3fb81e621acb2bb8)

## [1.0.9](https://github.com/loophp/collection/compare/1.0.8...1.0.9) - 2020-01-06

### Commits

- Fix behavior of ::filter() operation. [`bc2d733`](https://github.com/loophp/collection/commit/bc2d733a47782c614e20012b4dfe31b651f60fca)

## [1.0.8](https://github.com/loophp/collection/compare/1.0.7...1.0.8) - 2020-01-06

### Commits

- Increase default Grumphp timeout to avoid useless failures in CI. [`03a53fa`](https://github.com/loophp/collection/commit/03a53fa6bf5fb73137a57f141b8dc2ad411c8fbb)
- Fix PHPStan error. [`06c5f62`](https://github.com/loophp/collection/commit/06c5f626fa200e638b65c2840c04fa3368f9f19f)
- Use self keyword. [`59b6fa8`](https://github.com/loophp/collection/commit/59b6fa81894e800cd98950f1421312ee6bd4ce0b)
- Update the ::times() operation. [`7737e07`](https://github.com/loophp/collection/commit/7737e07aaa0740420a0d53a97946e54e96f121cc)
- Update the ::sort() operation using a new SortableIterableIterator object. [`f57c286`](https://github.com/loophp/collection/commit/f57c2867c4b80e3e5ad2dc91c0d9b6bc24935fe8)
- Update documentation. [`ff360a6`](https://github.com/loophp/collection/commit/ff360a6595a4a82bd7a19e690e121d641fa9cbb6)
- Minor optimizations and rephrases. [`675f4ab`](https://github.com/loophp/collection/commit/675f4abd77ff2a78b676e2a1a914936e565a094e)

## [1.0.7](https://github.com/loophp/collection/compare/1.0.6...1.0.7) - 2020-01-03

### Commits

- Add new methods: ::combinate() and ::permutate(). [`c55a2ef`](https://github.com/loophp/collection/commit/c55a2ef4d6773af3a1228b1ad9338186f9071120)
- Minor rewrite. [`44889cd`](https://github.com/loophp/collection/commit/44889cd5a196437c95bd55e6b0f2e4b4eba23232)

## [1.0.6](https://github.com/loophp/collection/compare/1.0.5...1.0.6) - 2020-01-02

### Commits

- Add Product operation to compute the cartesian product. [`1940b16`](https://github.com/loophp/collection/commit/1940b1679ded1c2c5acfd3f9819bd58b478e5a28)
- Update default documentation homepage. [`0507b69`](https://github.com/loophp/collection/commit/0507b6929a8628bd1ed96df2945c477f1e89e69a)
- First stab at documentation. [`0231878`](https://github.com/loophp/collection/commit/0231878f7119c5b53265393cedd227aa73600332)
- First stab at documentation. [`a847123`](https://github.com/loophp/collection/commit/a847123979593adfb74b45f5676206d17efe13cb)
- First stab at documentation. [`8178972`](https://github.com/loophp/collection/commit/81789725822da4c0c17367b423ee8f4dc2e86c08)

## [1.0.5](https://github.com/loophp/collection/compare/1.0.4...1.0.5) - 2020-01-01

### Commits

- Transfer repository to https://github.com/loophp [`92551d7`](https://github.com/loophp/collection/commit/92551d7b614b52606626657064564a2942559c90)
- Update default documentation homepage. [`4326a62`](https://github.com/loophp/collection/commit/4326a62dcf25f4eb361a51585fc50c5715c51b2d)
- Update Reduction operation. [`8964acc`](https://github.com/loophp/collection/commit/8964acc2a22ce3fe74140b8cb126e856a024b05c)
- Update Filter operation using \CallbackFilterIterator. [`96decd5`](https://github.com/loophp/collection/commit/96decd5ab51a3487e14049622b72c835d7483b68)
- Update Cycle operation. [`940beb4`](https://github.com/loophp/collection/commit/940beb409bd7347f637c25f9c9f9c624c828ebe5)
- Use LimitIterator. [`e999465`](https://github.com/loophp/collection/commit/e999465ed17dee7d117296b22351b1961ee9848b)
- Reduce operation, set the initial parameter to null by default. [`2aee709`](https://github.com/loophp/collection/commit/2aee709397b8e5d024e3c3157653da468cc3b8d2)
- Update PHPSpec configuration. [`d9a6b04`](https://github.com/loophp/collection/commit/d9a6b0436cdcdb513e7f8918c126d705383d1c18)
- Minor rephrase. [`d597a13`](https://github.com/loophp/collection/commit/d597a130291fa4a33fdf54b598b90fd538762fc9)
- Reduce CI builds using cache. [`dc64469`](https://github.com/loophp/collection/commit/dc64469e17af4b38bd3caaceb2c516a30081ad50)

## [1.0.4](https://github.com/loophp/collection/compare/1.0.3...1.0.4) - 2019-12-26

### Commits

- Remove unneeded ArrayIterators and use simple arrays. [`01d5ae2`](https://github.com/loophp/collection/commit/01d5ae2fc434df121c0b312d189b62ab06519412)
- Minor changes here and there. [`97769de`](https://github.com/loophp/collection/commit/97769de7611d32351cad87f5e891584d26a09f9c)
- Introduce an IterableIterator to reduce duplicated code here and there. [`9fe3d5a`](https://github.com/loophp/collection/commit/9fe3d5a0460bbc7c1b44972f4bcf06a97095d5ef)
- Update composer.json. [`b3b3eed`](https://github.com/loophp/collection/commit/b3b3eed97bfb2c6a85fd51201d7eeff12c705a4a)
- Update Github actions workflow. [`bc48ab2`](https://github.com/loophp/collection/commit/bc48ab22eef7a0b2ac014ba5830d7781566d386e)
- Update chunk operation. [`cba479e`](https://github.com/loophp/collection/commit/cba479e2c6532c0cbea4f18126a4b4c0300c059c)
- Update README. [`b7853d9`](https://github.com/loophp/collection/commit/b7853d9079887be97a5d190b44464a0ff6e310f1)

## [1.0.3](https://github.com/loophp/collection/compare/1.0.2...1.0.3) - 2019-12-25

### Commits

- Fix bug in ClosureIterator::rewind(). [`f3779ae`](https://github.com/loophp/collection/commit/f3779ae5e4552e3aa9a0c222fc8de4f42e82a50c)

## [1.0.2](https://github.com/loophp/collection/compare/1.0.1...1.0.2) - 2019-12-23

### Commits

- Add Tail and Reverse Operations. [`bae14bf`](https://github.com/loophp/collection/commit/bae14bfe0626fc5976196358c50fd6b46c5f4bf0)
- Update README. [`a80afcd`](https://github.com/loophp/collection/commit/a80afcd70c09abe3c1791d71beb8a18ac96ce96d)
- Update code style. [`83a8a2e`](https://github.com/loophp/collection/commit/83a8a2ea32eb80616692b780a3f79d8ad4898aaf)
- Update README. [`3fe2705`](https://github.com/loophp/collection/commit/3fe270528653105e926ecc42316a746c93e4f41d)
- Remove PHP 7.4 not available yet. [`1841f7f`](https://github.com/loophp/collection/commit/1841f7fcb13bccb946393e2ae62feb83585e851a)
- Remove installation of Graphviz. [`1d4ef3c`](https://github.com/loophp/collection/commit/1d4ef3ca1ad117dc4dd45419c84acf9e79237717)
- Fix PHPStan warnings. [`c1df8d3`](https://github.com/loophp/collection/commit/c1df8d3037f02f41e00b63a95b3ddaa3c7b31d56)
- Add missing tests. [`07f4859`](https://github.com/loophp/collection/commit/07f485978e2d869da1fdb4a0f3145e806a269f6c)
- Update PHPSpec min version. [`73ece19`](https://github.com/loophp/collection/commit/73ece19350941bdbb1a736e51fa33775708082c1)
- Static files cleanup. [`d484b1c`](https://github.com/loophp/collection/commit/d484b1c584423750025564c44c43c1f9b1c29d04)
- New operation: Scale [`ac6fd27`](https://github.com/loophp/collection/commit/ac6fd27d852876a3ee930a305181cc5a2c01fc10)

## [1.0.1](https://github.com/loophp/collection/compare/1.0.0...1.0.1) - 2019-12-06

### Commits

- Cast array keys as string by default in Flip operation. [`905d3fb`](https://github.com/loophp/collection/commit/905d3fbc2b89abb7a12dee4bd20de4939dbb6bcf)

## [1.0.0](https://github.com/loophp/collection/compare/0.0.17...1.0.0) - 2019-11-12

### Commits

- Update code style. [`eb98244`](https://github.com/loophp/collection/commit/eb98244389bd5bc7474c102dc99a17c37ea0583a)
- Rename minor stuff. [`ec8ee0e`](https://github.com/loophp/collection/commit/ec8ee0e859b0f3ddefda8361f00a167f38b3ba88)

## [0.0.17](https://github.com/loophp/collection/compare/0.0.13...0.0.17) - 2019-09-23

### Commits

- Update README example. [`03c7f87`](https://github.com/loophp/collection/commit/03c7f875791301c7081b62e96fcb4241097e3fad)
- Renaming. [`d1777a8`](https://github.com/loophp/collection/commit/d1777a85ead42d499ca125cd23fca4c1039d4291)
- Update composer.json. [`3dd5d4a`](https://github.com/loophp/collection/commit/3dd5d4ad75e72dc71a33d33e30a312fa91285dfe)
- Update the way the constructor is working. [`5baf106`](https://github.com/loophp/collection/commit/5baf1069341374f4aabed401b3870f326859c43a)
- Update ClosureIterator. [`f691cfb`](https://github.com/loophp/collection/commit/f691cfb59257551c40829c9cc2de6692a89bdd43)
- Update tests. [`5e105da`](https://github.com/loophp/collection/commit/5e105da9885ac28d4c861f31d13664ceb2527edf)
- Increase Grumphp timeout. [`1bc3cb8`](https://github.com/loophp/collection/commit/1bc3cb8854f5b7efd473f203ed544732efa63990)

## [0.0.13](https://github.com/loophp/collection/compare/0.0.12...0.0.13) - 2019-09-14

### Commits

- Add the Until operation with tests and example in README. [`4c73fe4`](https://github.com/loophp/collection/commit/4c73fe487798bc557008ce29404d776db71e6ca3)
- Update the ::iterate() static method. [`debec59`](https://github.com/loophp/collection/commit/debec59e8f27ad6fe814688db24b2d884c976dfb)
- Use str_plit() instead of mb_str_split(). [`48dfce7`](https://github.com/loophp/collection/commit/48dfce7b6846ae9d17286f216f4744773c2cdc90)
- Move the creation of the new Collection in the Base class. [`70181f5`](https://github.com/loophp/collection/commit/70181f56f65fc9e7a4d0a2e3a8beb1ab7955bd67)
- Add the Cycle operation. [`b82b610`](https://github.com/loophp/collection/commit/b82b610126f5a90e6ac2cafd79be863c13588747)
- Update README. [`6f4cddf`](https://github.com/loophp/collection/commit/6f4cddf7363e41a67a4c59df179138590f8cd063)

## [0.0.12](https://github.com/loophp/collection/compare/0.0.11...0.0.12) - 2019-09-09

### Commits

- Update README. [`55f7c56`](https://github.com/loophp/collection/commit/55f7c56c37b89c768e5125fc8ba7fb506dc5e82a)
- Minor cosmetic update. [`ae0e00b`](https://github.com/loophp/collection/commit/ae0e00b96820ee716f58a0b11055a181ea23f1c9)
- Add the Explode operation. [`e21e84f`](https://github.com/loophp/collection/commit/e21e84f11fcfc9fad83129bc81c577a5d8e7a7d1)
- If a string is passed as parameter, it will be passed through mb_str_split(). [`b2007be`](https://github.com/loophp/collection/commit/b2007be5ab46cc10eb6ce36585795b562af4c952)
- Pass the key to the Reduce and Recuction operations. [`ca60af0`](https://github.com/loophp/collection/commit/ca60af0e9cfa5129c7a95d404d36580b22485def)
- Minor change in the First transform operation. [`b8a7556`](https://github.com/loophp/collection/commit/b8a7556746e2ac84d9fa8eabf11abea52e58c731)
- Update Pluck operation. [`9e96a94`](https://github.com/loophp/collection/commit/9e96a942e3c56a79e9e66130fed6fc88a2b221d5)
- Update the ::iterate() static method. [`994772c`](https://github.com/loophp/collection/commit/994772c8a6d3b751af310a127f9b67fec9ff0bab)
- Update README. [`2351988`](https://github.com/loophp/collection/commit/2351988a5a167dfde47d8d819f12b6dcb6efd705)
- Add the Split operation. [`2e0dc1a`](https://github.com/loophp/collection/commit/2e0dc1a5002a118f250d61ac52c50e6641496c46)
- Simplify the times() method. [`6d8014b`](https://github.com/loophp/collection/commit/6d8014bd67c6320741720e66adaa55d52a216d80)
- Differentiate Operation and Transformation. [`3546cfa`](https://github.com/loophp/collection/commit/3546cfab79a3b7778d9e68027de1f369a01ec003)

## [0.0.11](https://github.com/loophp/collection/compare/0.0.10...0.0.11) - 2019-09-03

### Commits

- Update README. [`3e59719`](https://github.com/loophp/collection/commit/3e59719ce0d86f82a834ff915f3e15fe8e99325a)
- Fix bug with rebase method. [`72dd937`](https://github.com/loophp/collection/commit/72dd937bbd12950e5064dc71daba59018ec2e931)
- Update PHPDoc. [`16166ea`](https://github.com/loophp/collection/commit/16166eaf2b235ce4426629a0c325ea0ba83639d9)
- Add distinct() dans rsample() methods. [`898a3b1`](https://github.com/loophp/collection/commit/898a3b1f01fbd5fc2746247ad0cfda5d30a7ff6c)
- Update the ::iterate() method. [`e677738`](https://github.com/loophp/collection/commit/e677738debc62fe231de4b36915be2e38e8d805b)

## [0.0.10](https://github.com/loophp/collection/compare/0.0.9...0.0.10) - 2019-09-01

### Commits

- Align return types. [`95dbce9`](https://github.com/loophp/collection/commit/95dbce9eb945236ab54aca1e954d1089806f9b4f)
- Update the Chunk operation. [`d61bac3`](https://github.com/loophp/collection/commit/d61bac31cd42181c94b85f9262f4356929c3e5ae)
- Add static method ::iterate(). [`3306602`](https://github.com/loophp/collection/commit/330660214ae8978d3b818ef7a9d969e90819e4a7)
- Move the run() method from Collection to Base. [`55a0e3d`](https://github.com/loophp/collection/commit/55a0e3d71ef9d05a65adce66917203094514116f)
- Remove Operation abstract class. [`71f2702`](https://github.com/loophp/collection/commit/71f2702a73037c4d2f8578b19fd03f253c0f5c7e)
- Update .gitattributes. [`163b782`](https://github.com/loophp/collection/commit/163b78261d49e5a6af8f27ceb0bdbf230533c722)
- Use is_iterable(). [`a07681b`](https://github.com/loophp/collection/commit/a07681b0e93f03334bca3d2969efaede905b723d)

## [0.0.9](https://github.com/loophp/collection/compare/0.0.8...0.0.9) - 2019-09-01

### Commits

- Update README wording. [`ccaa796`](https://github.com/loophp/collection/commit/ccaa79683b945ea902af485bf74fcf72976e8936)
- Minor phpdoc update. [`724c166`](https://github.com/loophp/collection/commit/724c166c660420f82f52eca4a77a563e4c70a77f)
- Update README - Add more documentation. [`a69e246`](https://github.com/loophp/collection/commit/a69e246aa5e338f6b42d0fb89155113e23c313ef)
- Add Reduction operation. [`a749765`](https://github.com/loophp/collection/commit/a749765fa94f9510d34dfc8ef4f50b3f6c5feded)
- Update Infection score. [`4ad72c2`](https://github.com/loophp/collection/commit/4ad72c2630820424cc1841e47490d20c6f848272)
- Update code style for foreach loops and minor other things. [`faa0112`](https://github.com/loophp/collection/commit/faa0112d1667e483dc0b2b29259ddaa10688e739)
- Override static::with() so we can have autocomplete working in IDE. [`7057e09`](https://github.com/loophp/collection/commit/7057e09024f56bd305796ec971de6b0e478a0069)
- Create new Base object and Collection is now extending it and final. [`b3e0d19`](https://github.com/loophp/collection/commit/b3e0d19c9a143faa043b7034c863c4890b897ce6)

## [0.0.8](https://github.com/loophp/collection/compare/0.0.7...0.0.8) - 2019-08-29

### Commits

- Remove useless BaseCollection. [`c8aca3c`](https://github.com/loophp/collection/commit/c8aca3c20089c2f0d468ff4604e3884383e70b4d)
- Update the return type of Operation interfaces. [`da1ab80`](https://github.com/loophp/collection/commit/da1ab805155f360b93ccffbd359df85f6c44cd42)
- Use is_iterable() instead of \Traversable. [`711611b`](https://github.com/loophp/collection/commit/711611b20dd2aa63558b45563b0a48fcfbe50c0e)
- Make the Apply operation lazy. [`37ad7bd`](https://github.com/loophp/collection/commit/37ad7bd62c84b3f8737d3b31561b893da7c9780c)
- Let the BaseCollection implements the Runable interface. [`64f3808`](https://github.com/loophp/collection/commit/64f3808ad924c890dcc96a1ae784ad4553a7aed7)
- Add Implode operation. [`1e3b34b`](https://github.com/loophp/collection/commit/1e3b34b809c247d5d0bb57f7fd6d2735aca531ed)
- Use iterable instead of \Traversable. [`4eb5c88`](https://github.com/loophp/collection/commit/4eb5c887773486cca6a7bcae238c3a4c8723efc6)

## [0.0.7](https://github.com/loophp/collection/compare/0.0.6...0.0.7) - 2019-08-27

### Commits

- Refactoring. [`5b2a0cf`](https://github.com/loophp/collection/commit/5b2a0cf0792f5fbc96e507ab8c396156e0db32ba)

## [0.0.6](https://github.com/loophp/collection/compare/0.0.5...0.0.6) - 2019-08-22

### Commits

- Minor update on Collection class. [`a543106`](https://github.com/loophp/collection/commit/a543106aca9a05c6243611a2d9c66d29edfb6070)
- Do not let Operations wrap the return of ::run() in a collection. [`8cfd4eb`](https://github.com/loophp/collection/commit/8cfd4ebfff5dc6c7674e5bc3501b862783199cac)
- Minor change - Update operations. [`38d8f71`](https://github.com/loophp/collection/commit/38d8f71ddc2e33a070e789c16bfefa6f6e081005)
- New interfaces, more abstraction and flexibility. [`0add9fc`](https://github.com/loophp/collection/commit/0add9fcc6113bf789f9adbecb933d59a829880fc)
- Minor update. [`8db4ccf`](https://github.com/loophp/collection/commit/8db4ccfc4789532a7d6aabd5dd218660020c26e4)
- Minor Operations updates. [`c59054f`](https://github.com/loophp/collection/commit/c59054fcc6340d7dc9e2d9495e6801c68b511124)
- Minor update. [`2d2b6d9`](https://github.com/loophp/collection/commit/2d2b6d9e737c011e442903c96ccca94c38b65de2)
- Add Intersperse method/operation. [`913aa8c`](https://github.com/loophp/collection/commit/913aa8c2c4f32bf98b4fa586638dc14885100176)
- Update code style. [`d8e0c79`](https://github.com/loophp/collection/commit/d8e0c7911ea7402e460f8400f854cfd94aa96bd6)
- Update Last operation. [`af9e6a8`](https://github.com/loophp/collection/commit/af9e6a8ddbec28f269ad0d16b216a8786cb676b6)

## [0.0.5](https://github.com/loophp/collection/compare/0.0.4...0.0.5) - 2019-08-21

### Commits

- Update README. [`3fcbf00`](https://github.com/loophp/collection/commit/3fcbf00b4bbcb42db752a8df6554f302deb62d38)
- Add return type to Closures. [`a2b9366`](https://github.com/loophp/collection/commit/a2b93665bb7973b4c2b5cebec0054dfd1d03b087)
- Add ::sort() method and Operation. [`e50bbfd`](https://github.com/loophp/collection/commit/e50bbfd89f8d10b28a2d637ec7338b2b009653fe)
- Add ::last() method. [`9ea67a4`](https://github.com/loophp/collection/commit/9ea67a421dd7aebecd0314b135b5343b9cfa4748)
- Update count() method. [`baf96eb`](https://github.com/loophp/collection/commit/baf96eb6b9e3e55fc95b6ed40ca6998698133bbd)
- Minor update. [`04739ad`](https://github.com/loophp/collection/commit/04739ad5e9d8a9d5ee00994fb5e3cd73dd5b341b)
- Let the Filter operation use a variadic parameter. [`fd081c2`](https://github.com/loophp/collection/commit/fd081c23475e5d29832fe9e6b5b66078e0630f8f)

## [0.0.4](https://github.com/loophp/collection/compare/0.0.3...0.0.4) - 2019-08-20

### Commits

- Update README. [`b4050b5`](https://github.com/loophp/collection/commit/b4050b5fdd5e48209327642fb1013d8416f2ff2a)
- Add Run operation. [`1bf34d4`](https://github.com/loophp/collection/commit/1bf34d46f929854a642deb3e53c35ef01048df8b)
- Add .gitattributes. [`a41491c`](https://github.com/loophp/collection/commit/a41491c0a6414b957f6bcd0cac5a6d73f2d72156)
- Minor code updates and increase code coverage. [`89aa7a1`](https://github.com/loophp/collection/commit/89aa7a12e316f5c21e4e78ae05955b6205175206)

## [0.0.3](https://github.com/loophp/collection/compare/0.0.2...0.0.3) - 2019-08-19

### Commits

- Update README. [`831850e`](https://github.com/loophp/collection/commit/831850efae0a977b870a44297deef354cbede356)
- Use ::with() method everywhere. [`748a618`](https://github.com/loophp/collection/commit/748a618d8ef33a26d358d476f672dd295464cf99)
- Update composer.json [`534f374`](https://github.com/loophp/collection/commit/534f3742ba8ac62e127d73dfd7dfb644b7cf670e)
- Add more operations. [`d658c49`](https://github.com/loophp/collection/commit/d658c49f1b51e8803b0a48300e4a12cc0c22a645)
- Use ::empty(). [`2bb704b`](https://github.com/loophp/collection/commit/2bb704baae6aa51a8ad7fceef34d277defbebb26)
- Add Apply operation. [`2ef2342`](https://github.com/loophp/collection/commit/2ef23425c477b46892a8b133dd24639970cd6a38)
- Update README. [`1bb26c2`](https://github.com/loophp/collection/commit/1bb26c29a254259e25c9f75c2a08610111d78b62)
- Update Zip operation using proxy methods. [`0d7e849`](https://github.com/loophp/collection/commit/0d7e849e2668e7ac1b5a8012881f09ade46b5e03)
- Add ::proxy() operation. [`4bba092`](https://github.com/loophp/collection/commit/4bba0927bd7efd0375a512986db5b750f0015d85)
- Add ::Rebase() operation, update code and tests. [`a9127d8`](https://github.com/loophp/collection/commit/a9127d82dab6192ba85183c1c47ba8d2efe3e97b)
- Update the Zip operation. [`660f8ad`](https://github.com/loophp/collection/commit/660f8ad0c16ecb9c98dd5f6e14768f3fa164fd59)
- Add ::pluck() method/operation. [`8b9c53b`](https://github.com/loophp/collection/commit/8b9c53b5c596ed607aba6bde01ac148ef657a6c0)
- Update documentation. [`d50b257`](https://github.com/loophp/collection/commit/d50b257efade37b2d7311de8001a9ee649f2bba6)
- Update code style using latest version of drupol/drupal-conventions. [`ad60162`](https://github.com/loophp/collection/commit/ad60162521882a5e2177c30de49af53040c17e17)
- Update ::get() method. [`b78b672`](https://github.com/loophp/collection/commit/b78b672483a381b8c0082c7f6b1034f9c93302b9)

## [0.0.2](https://github.com/loophp/collection/compare/0.0.1...0.0.2) - 2019-08-13

### Commits

- Update composer.json. [`c9aff7b`](https://github.com/loophp/collection/commit/c9aff7b86e8d4de28828e0edfa3b9aa8bdde0d3c)
- Minor code changes. [`d645d47`](https://github.com/loophp/collection/commit/d645d478624b9096f57d933aadd7d04023411917)
- Move static methods out of the Collection interface. [`7677b5d`](https://github.com/loophp/collection/commit/7677b5db4021ee71bfc28657b14f3e4ad6c133ce)
- Minor README file update. [`6659473`](https://github.com/loophp/collection/commit/6659473c74aeee2bbf1fb683ffc2086cd11ecf01)
- Update code. [`d95b896`](https://github.com/loophp/collection/commit/d95b896ac735b82605c4196accaf0c6e15154038)
- Increase code coverage. [`e73924a`](https://github.com/loophp/collection/commit/e73924a678a573c403fe8245c62a7f9b5060e470)
- Use updated drupol/phpcsfixer-configs-php with PSR12 rule update. [`a1143c7`](https://github.com/loophp/collection/commit/a1143c7eda0ae4ddd26865b7ad505d920edd2c5a)
- Use phpstan/phpstan-strict-rules. [`83a4e4d`](https://github.com/loophp/collection/commit/83a4e4dfce55695ef7871c7da90d1f9458fc9e69)

## 0.0.1 - 2019-08-12

### Commits

- Initial commit. [`7247de4`](https://github.com/loophp/collection/commit/7247de4a70a6ef6f7d4b019460a68f5c8a06fb30)
