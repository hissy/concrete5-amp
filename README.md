# concrete5-amp

Accelerated Mobile Pages (AMP) for concrete5 site

**This package is still under beta. Please use at your own risk.**

## Install

```bash
$ cd ./packages
$ git clone git@github.com:hissy/concrete5-amp.git amp
$ cd ../
$ ./concrete/bin/concrete5 c5:package-install amp
```

## How to Setup

1. Access to `/index.php/dashboard/system/seo/amp`
2. Select Page Types to activate AMP
3. Input Google Analytics Property ID (Optional)
4. Save

## How to replace publisher logo and default thumbnail image

* Put publisher.png and thumbnail.png into `application/images/` directory.
* publisher.png must be 600px width and 60px height.
* thumbnail.png should be 1280px width and 720px height.

## How to customise design template

* Copy `packages/themes/amp` directory and files to `application/themes/amp`

## References

* [AMP Official Site](https://www.ampproject.org/)
* [Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool/)
* [AMP Testing Tool](https://search.google.com/search-console/amp)

## License

MIT License
